<x-mail::message>
# Appointment Modified

Hello {{ $appointment->user->name }},

Your appointment has been **successfully updated**. Please review your new appointment details below:

<x-mail::panel>
**New Date:** {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}  
**New Time:** {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}  
**Barber:** {{ $appointment->barber->name ?? 'Our barber' }}  
**Service:** {{ $appointment->service ?? 'Haircut' }}  
</x-mail::panel>

If you need to make any further changes, please log in to your account dashboard.

<x-mail::button :url="route('dashboard')">
View Appointment
</x-mail::button>

Stay sharp,<br>
The KapoBarber Team
</x-mail::message>
