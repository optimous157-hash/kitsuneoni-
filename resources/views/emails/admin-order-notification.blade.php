<x-mail::message>
# New Order Received

A new order has been placed.

<x-mail::table>
| | |
|:-------------|:-------------|
| **Reference** | {{ $order->reference_number }} |
| **Customer** | {{ $order->customer_name }} |
| **Email** | {{ $order->customer_email }} |
| **Phone** | {{ $order->customer_phone }} |
| **Country** | {{ $order->customer_country }} |
| **City** | {{ $order->customer_city }} |
| **Total** | ${{ number_format($order->total, 0) }} |
</x-mail::table>

### Items Ordered

@foreach($items as $item)
- **{{ $item->product_name }}** × {{ $item->quantity }} — ${{ number_format($item->total_price, 0) }}
@endforeach

@if($order->notes)
### Customer Notes
{{ $order->notes }}
@endif

### Shipping Address
{{ $order->customer_address }}, {{ $order->customer_city }}, {{ $order->customer_country }}

<x-mail::button :url="route('admin.orders.show', $order->id)">
View Order in Admin
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
