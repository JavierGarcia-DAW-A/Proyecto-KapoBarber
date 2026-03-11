<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Kapo Barber') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/barber.css') }}">
    </head>
    <body class="auth-container">
        <div>
            <a href="/">
                <img src="/Proyecto-KapoBarber/wp-content/themes/kapo-barber/assets/img/logo/logo.png" style="width: 150px; margin-bottom: 2rem;" alt="Logo">
            </a>
        </div>
        
        <div style="text-align: center;">
            <p style="margin-bottom: 2rem;">Welcome to the Kapo Barber Booking System.</p>
            
            <div style="display: flex; gap: 1rem; justify-content: center;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary" style="background-color: #1f1f1f; border-color: #4a4a4a; color: #fff;">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </body>
</html>
