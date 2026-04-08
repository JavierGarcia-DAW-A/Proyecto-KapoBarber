<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Barbers;
use App\Services\WordPressService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    protected $wpService;

    public function __construct(WordPressService $wpService)
    {
        $this->wpService = $wpService;
    }

    /**
     * Fetch barbers from WP and sync them to local DB so we can reference them.
     */
    protected function syncBarbers()
    {
        return \Illuminate\Support\Facades\Cache::remember('synced_barbers_cache_v2', now()->addHour(), function () {
            $wpBarbers = $this->wpService->getBarbers();
            if (!empty($wpBarbers)) {
                foreach ($wpBarbers as $wb) {
                    Barbers::updateOrCreate(
                        ['wp_id' => $wb['id']],
                        [
                            'name' => $wb['name'],
                            'slug' => $wb['slug'],
                        ]
                    );
                }
            } else {
                // FALLBACK: Si WordPress falla, crear 3 peluqueros de prueba en la base de datos local
                if (Barbers::count() === 0) {
                    Barbers::insert([
                        ['wp_id' => 1001, 'name' => 'Guy C. Pulido BKS (Master Barber)', 'slug' => 'guy-pulido', 'created_at' => now(), 'updated_at' => now()],
                        ['wp_id' => 1002, 'name' => 'Steve L. Nolan (Color Expart)', 'slug' => 'steve-nolan', 'created_at' => now(), 'updated_at' => now()],
                        ['wp_id' => 1003, 'name' => 'Edgar P. Mathis (Master Barber)', 'slug' => 'edgar-mathis', 'created_at' => now(), 'updated_at' => now()]
                    ]);
                }
            }
            return Barbers::all();
        });
    }

    public function create()
    {
        // On page load, fetch latest barbers from WP to keep everything synced
        $barbers = $this->syncBarbers();
        return view('appointments.create', compact('barbers'));
    }

    public function getAvailableTimes(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'barber_id' => 'required|exists:barbers,id',
        ]);

        $date = Carbon::parse($request->date);
        
        // Rules check
        if ($date->isSunday()) {
            return response()->json([]); // Closed on Sundays
        }

        $times = [];

        // Morning Shift: 09:00 - 14:00 (for Mon-Sat)
        $start_morning = Carbon::parse($request->date . ' 09:00');
        $end_morning = Carbon::parse($request->date . ' 14:00');

        while ($start_morning < $end_morning) {
            $times[] = $start_morning->format('H:i');
            $start_morning->addMinutes(30);
        }

        // Afternoon Shift: 16:00 - 21:00 (for Mon-Fri ONLY)
        if (!$date->isSaturday()) {
            $start_afternoon = Carbon::parse($request->date . ' 16:00');
            $end_afternoon = Carbon::parse($request->date . ' 21:00');

            while ($start_afternoon < $end_afternoon) {
                $times[] = $start_afternoon->format('H:i');
                $start_afternoon->addMinutes(30);
            }
        }

        // Filter out times already booked or in the past
        $bookedTimes = Appointment::where('date', $request->date)
            ->where('barber_id', $request->barber_id)
            ->pluck('time')
            ->map(fn($t) => substr($t, 0, 5)) // get H:i from H:i:s
            ->toArray();

        $now = Carbon::now();
        $isToday = $date->isToday();

        $availableTimes = array_filter($times, function($time) use ($bookedTimes, $now, $isToday, $request) {
            if (in_array($time, $bookedTimes)) {
                return false; // Booked
            }
            if ($isToday) {
                $slotTime = Carbon::parse($request->date . ' ' . $time);
                if ($slotTime <= $now) {
                    return false; // In past
                }
            }
            return true;
        });

        return response()->json(array_values($availableTimes));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'phone' => 'required|string|max:20', // New field
            'service' => 'required|string|max:100',
            'price' => 'required|numeric',
        ]);

        $date = Carbon::parse($request->date);
        if ($date->isSunday()) {
            return back()->withErrors(['date' => 'Appointments are not available on Sundays.']);
        }
        if ($date->isSaturday() && $request->time >= '14:00') {
            return back()->withErrors(['time' => 'Appointments on Saturdays are only available from 09:00 to 14:00.']);
        }

        // Validate again just to be sure
        $exists = Appointment::where('date', $request->date)
            ->where('barber_id', $request->barber_id)
            ->where('time', $request->time . ':00') // seconds
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'This time slot is already taken for the selected barber.']);
        }

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'barber_id' => $request->barber_id,
            'date' => $request->date,
            'time' => $request->time,
            'phone' => $request->phone,
            'service' => $request->service,
            'price' => $request->price,
        ]);

        $barberName = \App\Models\Barbers::find($request->barber_id)->name ?? 'Barbero';

        // Sincronizar con WordPress
        try {
            \Illuminate\Support\Facades\Http::post('http://localhost/Proyecto-KapoBarber/wp-json/kapo/v1/appointments', [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => $request->phone,
                'date' => $request->date,
                'time' => $request->time,
                'barber_name' => $barberName,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Fallo al enviar cita a WordPress: " . $e->getMessage());
        }

        try {
            \Illuminate\Support\Facades\Mail::to(auth()->user()->email)->send(new \App\Mail\AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send email: " . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('status', 'appointment-booked');
    }

    public function getEvents(Request $request)
    {
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $appointments = Appointment::where('barber_id', $request->barber_id)
            ->whereBetween('date', [Carbon::parse($request->start)->format('Y-m-d'), Carbon::parse($request->end)->format('Y-m-d')])
            ->get();

        $events = $appointments->map(function ($appt) {
            return [
                'title' => 'Booked',
                'start' => $appt->date . 'T' . $appt->time,
                'end' => Carbon::parse($appt->date . ' ' . $appt->time)->addMinutes(30)->format('Y-m-d\TH:i:s'),
                'color' => '#1b1b18', // styling it dark
                'display' => 'background', // display as a background block so the user knows it's unselectable
            ];
        });

        return response()->json($events);
    }

    public function edit(Appointment $appointment)
    {
        if (auth()->id() !== $appointment->user_id) {
            abort(403);
        }
        $barbers = $this->syncBarbers();
        return view('appointments.edit', compact('appointment', 'barbers'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (auth()->id() !== $appointment->user_id) {
            abort(403);
        }

        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'phone' => 'required|string|max:20',
            'service' => 'required|string|max:100',
            'price' => 'required|numeric',
        ]);

        // Validate duplicates (excluding current appointment)
        $exists = Appointment::where('date', $request->date)
            ->where('barber_id', $request->barber_id)
            ->where('time', $request->time . ':00')
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'This time slot is already taken for the selected barber.']);
        }

        $appointment->update($request->only('barber_id', 'date', 'time', 'phone', 'service', 'price'));

        return redirect()->route('dashboard')->with('status', 'appointment-updated');
    }

    public function getAdminEvents(Request $request)
    {
        // Admin can see all appointments across all barbers
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

        $appointments = Appointment::with(['user', 'barber'])
            ->whereBetween('date', [$start, $end])
            ->get();

        $events = $appointments->map(function ($appt) {
            return [
                'id' => $appt->id,
                'title' => $appt->user->name . ' - ' . ($appt->barber->name ?? 'Unknown Barber'),
                'start' => $appt->date . 'T' . $appt->time,
                'end' => Carbon::parse($appt->date . ' ' . $appt->time)->addMinutes(30)->format('Y-m-d\TH:i:s'),
                'color' => '#d19f68', // distinct color for admin view
                'extendedProps' => [
                    'client_email' => $appt->user->email,
                    'barber' => $appt->barber->name ?? 'Unknown'
                ]
            ];
        });

        return response()->json($events);
    }

    public function destroy(Appointment $appointment)
    {
        // Only allow admins or the owner of the appointment to delete
        if (!auth()->user()->is_admin && auth()->id() !== $appointment->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $appointment->delete();

        // Check if request expects JSON (like from FullCalendar/Fetch)
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('status', 'appointment-deleted');
    }
}
