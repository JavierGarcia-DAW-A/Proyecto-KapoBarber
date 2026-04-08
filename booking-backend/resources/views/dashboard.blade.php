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
                        <th style="text-align: left; padding: 10px; border-bottom: 2px solid #555;">Barber Name</th>
                        <th style="text-align: left; padding: 10px; border-bottom: 2px solid #555;">Service & Cost</th>
                        <th style="text-align: left; padding: 10px; border-bottom: 2px solid #555;">Date</th>
                        <th style="text-align: left; padding: 10px; border-bottom: 2px solid #555;">Time</th>
                        <th style="text-align: left; padding: 10px; border-bottom: 2px solid #555;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                    <tr>
                        <td style="padding: 10px; color: #d19f68; font-weight: bold; border-bottom: 1px solid #333;">{{ $app->barber->name ?? 'Unknown Barber' }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $app->service ?? 'Service not specified' }} <span style="color:#d19f68">(${{ $app->price ?? '0.00' }})</span></td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ \Carbon\Carbon::parse($app->date)->format('d/m/Y') }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ \Carbon\Carbon::parse($app->time)->format('H:i') }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('appointments.edit', $app->id) }}" style="color: #60a5fa; text-decoration: underline;">Modify</a>
                                <form action="{{ route('appointments.destroy', $app->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres anular esta cita?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #f87171; background: none; border: none; cursor: pointer; text-decoration: underline; padding: 0;">Cancel</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
