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

        <!-- Alpine -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="app-container">
        <nav>
            <div>
                <a href="/Proyecto-KapoBarber/" style="color: var(--gold); font-weight: bold; font-size: 1.25rem;">KAPO BARBER</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('dashboard') }}" style="margin-left: 2rem;">Admin Panel</a>
                @else
                    <a href="{{ route('dashboard') }}" style="margin-left: 2rem;">My Appointments</a>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #f87171; cursor: pointer; text-decoration: underline;">Log Out</button>
                </form>
            </div>
        </nav>

        @isset($header)
            <header class="app-header">
                {{ $header }}
            </header>
        @endisset

        <main class="app-main">
            {{ $slot }}
        </main>
    </body>
</html>
