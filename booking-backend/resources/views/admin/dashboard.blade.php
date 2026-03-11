<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0;">Admin Dashboard</h2>
        </div>
    </x-slot>

    <div class="card mt-4 mb-4">
        <h3 style="margin-bottom: 1rem;">All Appointments</h3>
        
        @if($appointments->isEmpty())
            <p style="color: #94a3b8;">No appointments have been booked yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Hairdresser</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                    <tr>
                        <td style="font-weight: 500;">{{ $app->user->name }}</td>
                        <td style="color: #94a3b8;">{{ $app->user->email }}</td>
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
