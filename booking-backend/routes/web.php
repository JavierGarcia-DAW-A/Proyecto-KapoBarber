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
            $userEmail = auth()->user()->email;
            $appointments = null;
            $orders = null;
            $citasStats = null;
            $productosStats = null;

            if ($userEmail !== 'productos@kapobarber.com') {
                $appointments = Appointment::with(['user', 'barber'])->orderBy('date', 'asc')->orderBy('time', 'asc')->get();
                
                $executedAppointments = Appointment::where('is_executed', 1)->get();
                $totalRevenueCitas = $executedAppointments->sum('price');
                
                $topService = $executedAppointments->groupBy('service')->map->count()->sortDesc()->keys()->first();
                
                $barberStats = $executedAppointments->groupBy('barber_id')->map(function ($apps) {
                    $barber = $apps->first()->barber;
                    return [
                        'name' => $barber ? $barber->name : 'Unknown',
                        'count' => $apps->count(),
                        'revenue' => $apps->sum('price')
                    ];
                });

                $citasStats = [
                    'total_revenue' => $totalRevenueCitas,
                    'top_service' => $topService,
                    'barbers' => $barberStats
                ];
            }

            if ($userEmail !== 'citas@kapobarber.com') {
                $orders = \App\Models\Order::with('user')->orderBy('created_at', 'desc')->get();
                
                $totalRevenueProductos = $orders->whereIn('status', ['Paid', 'Send', 'Delivered'])->sum('price');
                $productSales = $orders->whereIn('status', ['Paid', 'Send', 'Delivered'])->groupBy('product_name')->map(function ($items) {
                    return [
                        'count' => $items->count(),
                        'revenue' => $items->sum('price')
                    ];
                })->sortByDesc('count');

                $productosStats = [
                    'total_revenue' => $totalRevenueProductos,
                    'sales' => $productSales
                ];
            }

            return view('admin.dashboard', compact('appointments', 'orders', 'userEmail', 'citasStats', 'productosStats'));
        }

        if (auth()->user()->is_barber) {
            $barber = auth()->user()->barber;
            if($barber){
                $appointments = Appointment::where('barber_id', $barber->id)->with('user')->orderBy('date', 'asc')->orderBy('time', 'asc')->get();
                
                $executedApps = $appointments->where('is_executed', 1);
                $myStats = [
                    'total_executed' => $executedApps->count(),
                    'total_revenue' => $executedApps->sum('price')
                ];

                $nowThreshold = now()->subMinutes(30)->format('Y-m-d H:i:s');
                $closestAppointment = $appointments->filter(function($app) use ($nowThreshold) {
                    $datetime = \Carbon\Carbon::parse($app->date . ' ' . $app->time)->format('Y-m-d H:i:s');
                    return $app->is_executed === null && $datetime >= $nowThreshold;
                })->first();
                return view('barber.dashboard', compact('appointments', 'closestAppointment', 'myStats'));
            }
        }

        $appointments = auth()->user()->appointments()->with('barber')->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('appointments', 'orders'));
    })->name('dashboard');

    // Rutas Específicas del Administrador
    Route::middleware(\App\Http\Middleware\EnsureIsAdmin::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/appointments/events', [AppointmentController::class, 'getAdminEvents'])->name('appointments.events');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\CheckoutController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::resource('clients', \App\Http\Controllers\AdminClientController::class)->except(['create', 'store', 'show']);
        Route::post('clients/{client}/toggle-ban', [\App\Http\Controllers\AdminClientController::class, 'toggleBan'])->name('clients.toggleBan');

        Route::resource('barbers', \App\Http\Controllers\AdminBarberController::class)->except(['show']);
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

    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
});

Route::get('/logout-custom', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    setcookie("kapo_logged_in_user", "", time() - 3600, "/");
    return response()->json(['success' => true]);
})->name('logout.custom');

require __DIR__.'/auth.php';
