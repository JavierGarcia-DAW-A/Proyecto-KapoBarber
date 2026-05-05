<x-mail::message>
# Welcome to KapoBarber, {{ $user->name }}!

We're thrilled to have you join our community. At KapoBarber, we pride ourselves on providing the sharpest cuts and the finest grooming products.

You can now easily book appointments with our professional barbers and purchase exclusive products directly from your dashboard.

<x-mail::button :url="route('dashboard')">
Go to Dashboard
</x-mail::button>

Stay sharp,<br>
The KapoBarber Team
</x-mail::message>
