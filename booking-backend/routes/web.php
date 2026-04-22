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

        if (auth()->user()->is_barber) {
            $barber = auth()->user()->barber;
            if($barber){
                $appointments = Appointment::where('barber_id', $barber->id)->with('user')->orderBy('date', 'asc')->orderBy('time', 'asc')->get();
                $nowThreshold = now()->subMinutes(30)->format('Y-m-d H:i:s');
                $closestAppointment = $appointments->filter(function($app) use ($nowThreshold) {
                    $datetime = \Carbon\Carbon::parse($app->date . ' ' . $app->time)->format('Y-m-d H:i:s');
                    return $app->is_executed === null && $datetime >= $nowThreshold;
                })->first();
                return view('barber.dashboard', compact('appointments', 'closestAppointment'));
            }
        }

        $appointments = auth()->user()->appointments()->with('barber')->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        return view('dashboard', compact('appointments'));
    })->name('dashboard');

    // Rutas Específicas del Administrador
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
    Route::post('/appointments/{appointment}/executed', [AppointmentController::class, 'markExecuted'])->name('appointments.execute');
    Route::get('/appointments/available-times', [AppointmentController::class, 'getAvailableTimes'])->name('appointments.available');
    Route::get('/appointments/events', [AppointmentController::class, 'getEvents'])->name('appointments.events');
});

Route::get('/logout-custom', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    setcookie("kapo_logged_in_user", "", time() - 3600, "/");
    return response()->json(['success' => true]);
})->name('logout.custom');

require __DIR__.'/auth.php';
