<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AppointmentController;
use App\Models\Appointment;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            $appointments = Appointment::with(['user', 'barber'])->orderBy('date', 'asc')->orderBy('time', 'asc')->get();
            return view('admin.dashboard', compact('appointments'));
        }

        $appointments = auth()->user()->appointments()->with('barber')->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        return view('dashboard', compact('appointments'));
    })->name('dashboard');

    // Admin Specific Routes
    Route::middleware(\App\Http\Middleware\EnsureIsAdmin::class)->prefix('admin')->group(function () {
        Route::get('/appointments/events', [AppointmentController::class, 'getAdminEvents'])->name('admin.appointments.events');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('appointments.available');
    Route::get('/appointments/events', [AppointmentController::class, 'getEvents'])->name('appointments.events');
});

require __DIR__.'/auth.php';
