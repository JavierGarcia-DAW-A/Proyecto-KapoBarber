<x-mail::message>
# Appointment Cancelled

Hello {{ $appointmentData['user_name'] }},

This email is to confirm that your appointment has been **cancelled**. The details of the cancelled appointment are below:

<x-mail::panel>
**Date:** {{ \Carbon\Carbon::parse($appointmentData['date'])->format('F j, Y') }}  
**Time:** {{ \Carbon\Carbon::parse($appointmentData['time'])->format('h:i A') }}  
**Barber:** {{ $appointmentData['barber_name'] }}  
**Service:** {{ $appointmentData['service'] }}  
</x-mail::panel>

If this cancellation was a mistake or you wish to book a new appointment, you can do so easily through your dashboard.

<x-mail::button :url="route('appointments.create')">
Book a New Appointment
</x-mail::button>

Stay sharp,<br>
The KapoBarber Team
</x-mail::message>
