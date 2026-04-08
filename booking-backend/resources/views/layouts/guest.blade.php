<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts & Local CSS -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/barber.css') }}">
    </head>
    <body>
        <div class="auth-container">
            <div>
                <a href="/Proyecto-KapoBarber/">
                    <img src="/Proyecto-KapoBarber/wp-content/themes/kapo-barber/assets/img/logo/logo.png" style="max-width: 120px; height: auto; margin-bottom: 1rem;" alt="Logo">
                </a>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
