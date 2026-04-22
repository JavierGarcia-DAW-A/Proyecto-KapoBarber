<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-weight: bold; font-size: 1.25rem;">Barber Dashboard</h2>
        </div>
    </x-slot>

    @if (session('status') === 'appointment-executed-updated')
        <div style="color: #4ade80; margin-bottom: 1rem; margin-top:1rem;">
            Appointment execution status has been saved successfully!
        </div>
    @endif

    <div class="card mt-4 mb-4">
        @if($closestAppointment)
        <div style="background-color: #1e293b; padding: 20px; border-radius: 8px; border: 2px solid #d19f68; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="color: #d19f68; font-size: 1.5rem; margin-bottom: 0.5rem;">NEXT APPOINTMENT</h3>
            <div style="font-size: 1.2rem; margin-bottom: 1rem;">
                <strong>Client:</strong> {{ $closestAppointment->user->name }} ({{ $closestAppointment->phone }})<br>
                <strong>Service:</strong> <span style="color:#fbbf24;">{{ $closestAppointment->service }}</span> - ${{ $closestAppointment->price }}<br>
                <strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($closestAppointment->date)->format('d/m/Y') }} at {{ \Carbon\Carbon::parse($closestAppointment->time)->format('H:i') }}
            </div>
            
            <div style="background-color: #0f172a; padding: 15px; border-radius: 6px; text-align: center;">
                <p style="font-size: 1.1rem; font-weight: bold; margin-bottom: 15px;">¿Se ha ejecutado la cita?</p>
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <form action="{{ route('appointments.execute', $closestAppointment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_executed" value="1">
                        <button type="submit" style="background-color: #22c55e; color: white; padding: 10px 30px; font-size: 1.2rem; font-weight: bold; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#16a34a'" onmouseout="this.style.backgroundColor='#22c55e'">Sí</button>
                    </form>
                    
                    <form action="{{ route('appointments.execute', $closestAppointment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="is_executed" value="0">
                        <button type="submit" style="background-color: #ef4444; color: white; padding: 10px 30px; font-size: 1.2rem; font-weight: bold; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">No</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <h3 style="margin-bottom: 1rem;">All My Appointments</h3>
        
        @if($appointments->isEmpty())
            <p style="color: #94a3b8;">No appointments have been booked for you yet.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Client Name</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Service & Config</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Date</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Time</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $app)
                    <tr style="{{ $closestAppointment && $closestAppointment->id === $app->id ? 'background-color: rgba(209, 159, 104, 0.1);' : '' }}">
                        <td style="padding: 10px; font-weight: 500; border-bottom: 1px solid #333;">{{ $app->user->name }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $app->service ?? 'N/A' }} <span style="color:#d19f68">(${{ $app->price ?? '0.00' }})</span></td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ \Carbon\Carbon::parse($app->date)->format('d/m/Y') }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ \Carbon\Carbon::parse($app->time)->format('H:i') }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">
                            @if($app->is_executed === 1)
                                <span style="color: #4ade80;">Executed</span>
                            @elseif($app->is_executed === 0)
                                <span style="color: #ef4444;">Not Executed</span>
                            @else
                                <span style="color: #94a3b8;">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</x-app-layout>
