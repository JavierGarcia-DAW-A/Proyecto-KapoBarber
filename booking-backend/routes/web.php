<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AppointmentController;
use App\Models\Appointment;

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        $appointments = Appointment::with('user')->orderBy('date', 'asc')->orderBy('time', 'asc')->get();
        return view('admin.dashboard', compact('appointments'));
    }

    $appointments = auth()->user()->appointments()->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
    return view('dashboard', compact('appointments'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('appointments.available');
});

require __DIR__.'/auth.php';
