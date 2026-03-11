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
        $wpBarbers = $this->wpService->getBarbers();
        foreach ($wpBarbers as $wb) {
            Barbers::updateOrCreate(
                ['wp_id' => $wb['id']],
                [
                    'name' => $wb['name'],
                    'slug' => $wb['slug'],
                ]
            );
        }
        return Barbers::all();
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
        if ($date->isSunday() || $date->isSaturday()) {
            return response()->json([]); // Closed on weekends according to new rules (Mon-Fri only)
        }

        $times = [];

        // Morning Shift: 09:00 - 14:00
        $start_morning = Carbon::parse($request->date . ' 09:00');
        $end_morning = Carbon::parse($request->date . ' 14:00');

        while ($start_morning < $end_morning) {
            $times[] = $start_morning->format('H:i');
            $start_morning->addMinutes(30);
        }

        // Afternoon Shift: 16:00 - 20:00
        $start_afternoon = Carbon::parse($request->date . ' 16:00');
        $end_afternoon = Carbon::parse($request->date . ' 20:00');

        while ($start_afternoon < $end_afternoon) {
            $times[] = $start_afternoon->format('H:i');
            $start_afternoon->addMinutes(30);
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
        ]);

        $date = Carbon::parse($request->date);
        if ($date->isWeekend()) {
            return back()->withErrors(['date' => 'Appointments are only available Monday through Friday.']);
        }

        // Validate again just to be sure
        $exists = Appointment::where('date', $request->date)
            ->where('barber_id', $request->barber_id)
            ->where('time', $request->time . ':00') // seconds
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'This time slot is already taken for the selected barber.']);
        }

        Appointment::create([
            'user_id' => auth()->id(),
            'barber_id' => $request->barber_id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

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
}
