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

        <div style="display: flex; min-height: calc(100vh - 150px);">
            @if(auth()->user() && auth()->user()->is_admin)
                <aside style="width: 250px; background-color: #1e293b; border-right: 1px solid #333; padding: 20px;">
                    <h3 style="color: #d19f68; margin-bottom: 20px; font-size: 1.2rem;">Admin Menu</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="{{ route('dashboard') }}" style="color: white; text-decoration: none; padding: 10px; display: block; border-radius: 4px; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#334155'" onmouseout="this.style.backgroundColor='transparent'">Dashboard</a></li>
                        <li>
                            <details>
                                <summary style="color: white; padding: 10px; cursor: pointer; border-radius: 4px; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#334155'" onmouseout="this.style.backgroundColor='transparent'">Manage Users</summary>
                                <ul style="list-style: none; padding-left: 15px; margin-top: 10px; display: flex; flex-direction: column; gap: 5px;">
                                    <li><a href="{{ route('admin.clients.index') }}" style="color: #cbd5e1; text-decoration: none; display: block; padding: 5px;">Clients</a></li>
                                    <li><a href="{{ route('admin.barbers.index') }}" style="color: #cbd5e1; text-decoration: none; display: block; padding: 5px;">Barbers</a></li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </aside>
            @endif

            <main class="app-main" style="flex: 1; padding: 20px;">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
