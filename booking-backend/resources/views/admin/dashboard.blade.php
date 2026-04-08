<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-weight: bold; font-size: 1.25rem;">Admin Dashboard</h2>
        </div>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card mt-4 mb-4">
        <h3 style="margin-bottom: 1rem;">All Appointments List</h3>
        
        @if($appointments->isEmpty())
            <p style="color: #94a3b8;">No appointments have been booked yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Client Name</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Email</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Hairdresser</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Service & Price</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Date</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Time</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                    <tr id="row-{{ $app->id }}">
                        <td style="padding: 10px; font-weight: 500; border-bottom: 1px solid #333;">{{ $app->user->name }}</td>
                        <td style="padding: 10px; color: #94a3b8; border-bottom: 1px solid #333;">{{ $app->user->email }}</td>
                        <td style="padding: 10px; color: #d19f68; font-weight: bold; border-bottom: 1px solid #333;">{{ $app->barber->name ?? 'Unknown' }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $app->service ?? 'Service not specified' }} <span style="color:#d19f68">(${{ $app->price ?? '0.00' }})</span></td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ \Carbon\Carbon::parse($app->date)->format('d/m/Y') }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ \Carbon\Carbon::parse($app->time)->format('H:i') }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">
                            <form action="{{ route('admin.appointments.destroy', $app->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #f87171; background: none; border: none; cursor: pointer; text-decoration: underline; padding: 0;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


</x-app-layout>
