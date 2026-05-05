<x-mail::message>
# Order Confirmed!

Hello {{ $order->user->name }},

Thank you for your purchase! We've received your order and it is currently being processed.

<x-mail::panel>
**Product:** {{ $order->product_name }}  
**Price:** ${{ number_format($order->price, 2) }}  
**Status:** {{ $order->status }}
</x-mail::panel>

Your grooming essentials will be on their way soon. You can track your order status directly from your dashboard.

<x-mail::button :url="route('dashboard')">
View Order
</x-mail::button>

Stay sharp,<br>
The KapoBarber Team
</x-mail::message>
