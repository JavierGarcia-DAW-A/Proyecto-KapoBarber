<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">My Appointments</h2>
            <a href="{{ route('appointments.create') }}" class="btn-primary">
                Book Haircut
            </a>
        </div>
    </x-slot>

    <div class="card mb-4 mt-4">
        @if (session('status') === 'appointment-booked')
            <div style="color: #4ade80; margin-bottom: 1rem;">
                Your appointment has been successfully booked!
            </div>
        @endif

        <h3 style="margin-bottom: 1rem;">Upcoming Appointments</h3>
        
        @if($appointments->isEmpty())
            <p style="color: #94a3b8;">You don't have any appointments booked yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Hairdresser</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                    <tr>
                        <td style="color: var(--gold); font-weight: bold;">Hairdresser {{ $app->hairdresser_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($app->date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($app->time)->format('H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
