<x-mail::message>
# Appointment Confirmed!

Hello {{ $appointment->user->name }},

Your appointment has been successfully booked. We're looking forward to seeing you at the shop!

<x-mail::panel>
**Date:** {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}  
**Time:** {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}  
**Barber:** {{ $appointment->barber->name ?? 'Our barber' }}  
**Service:** {{ $appointment->service ?? 'Haircut' }}  
</x-mail::panel>

If you need to reschedule or cancel, please do so from your account dashboard at least 24 hours in advance.

<x-mail::button :url="route('dashboard')">
Manage Appointments
</x-mail::button>

Stay sharp,<br>
The KapoBarber Team
</x-mail::message>
