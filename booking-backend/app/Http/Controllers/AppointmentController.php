<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointments.create');
    }

    public function getAvailableTimes(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'hairdresser_id' => 'required|integer|in:1,2,3',
        ]);

        $date = Carbon::parse($request->date);
        
        // Rules check
        if ($date->isSunday()) {
            return response()->json([]); // Closed
        }

        $isSaturday = $date->isSaturday();
        $times = [];

        // Morning Shift: 09:00 - 14:00
        $start_morning = Carbon::parse($request->date . ' 09:00');
        $end_morning = Carbon::parse($request->date . ' 14:00');

        while ($start_morning < $end_morning) {
            $times[] = $start_morning->format('H:i');
            $start_morning->addMinutes(30);
        }

        // Afternoon Shift: 16:00 - 21:00 (Not for Saturdays)
        if (!$isSaturday) {
            $start_afternoon = Carbon::parse($request->date . ' 16:00');
            $end_afternoon = Carbon::parse($request->date . ' 21:00');

            while ($start_afternoon < $end_afternoon) {
                $times[] = $start_afternoon->format('H:i');
                $start_afternoon->addMinutes(30);
            }
        }

        // Filter out times already booked or in the past
        $bookedTimes = Appointment::where('date', $request->date)
            ->where('hairdresser_id', $request->hairdresser_id)
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
            'hairdresser_id' => 'required|integer|in:1,2,3',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        // Validate again just to be sure
        $exists = Appointment::where('date', $request->date)
            ->where('hairdresser_id', $request->hairdresser_id)
            ->where('time', $request->time . ':00') // seconds
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'This time slot is already taken.']);
        }

        Appointment::create([
            'user_id' => auth()->id(),
            'hairdresser_id' => $request->hairdresser_id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('dashboard')->with('status', 'appointment-booked');
    }
}
