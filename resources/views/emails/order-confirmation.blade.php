<x-mail::message>
# Order Confirmed

Thank you for your order, **{{ $order->customer_name }}**!

Your order has been received and is being processed.

<x-mail::table>
| | |
|:-------------|:-------------|
| **Reference** | {{ $order->reference_number }} |
| **Date** | {{ $order->created_at->format('M d, Y') }} |
| **Total** | ${{ number_format($order->total, 0) }} |
| **Status** | {{ ucfirst($order->status) }} |
</x-mail::table>

@foreach($items as $item)
**{{ $item->product_name }}** × {{ $item->quantity }} — ${{ number_format($item->total_price, 0) }}

@endforeach

@if($order->shipping_cost > 0)
**Shipping:** ${{ number_format($order->shipping_cost, 0) }}
@else
**Shipping:** Free
@endif

**Total:** ${{ number_format($order->total, 0) }}

---

### Shipping Details

**Name:** {{ $order->customer_name }}<br>
**Email:** {{ $order->customer_email }}<br>
**Phone:** {{ $order->customer_phone }}<br>
**Address:** {{ $order->customer_address }}, {{ $order->customer_city }}, {{ $order->customer_country }}

@if($order->notes)
### Notes
{{ $order->notes }}
@endif

<x-mail::button :url="config('app.url')">
View Our Shop
</x-mail::button>

Thank you for choosing Kitsuneoni.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
