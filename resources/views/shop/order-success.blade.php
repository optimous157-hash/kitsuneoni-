@extends('layouts.app')

@section('title', 'Order Confirmed — Kitsuneoni')
@section('description', 'Your order has been confirmed. We will contact you via email within 24 hours with next steps.')
@section('og_title', 'Order Confirmed — Kitsuneoni')
@section('og_description', 'Your Kitsuneoni order has been confirmed. We will contact you within 24 hours.')

@section('content')

<section class="py-20">
    <div class="container-premium max-w-2xl text-center">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-display font-bold text-yamagata-black dark:text-white mb-4">Order Confirmed!</h1>
        <p class="text-lg text-yamagata-silver mb-8">Thank you for your order. We'll send you a confirmation email shortly.</p>

        <div class="card-premium p-8 text-left mb-8">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-yamagata-silver">Reference Number</p>
                    <p class="text-lg font-bold text-yamagata-red font-mono">{{ $order->reference_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-yamagata-silver">Status</p>
                    <p class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-full text-sm font-medium">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                        {{ $order->status_label }}
                    </p>
                </div>
            </div>

            <div class="border-t border-yamagata-pearl/50 dark:border-yamagata-graphite/50 pt-6">
                <h3 class="font-semibold text-yamagata-black dark:text-white mb-3">Order Items</h3>
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 py-3">
                    @if($item->product_image)
                    <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-lg object-cover">
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-yamagata-black dark:text-white">{{ $item->product_name }}</p>
                        <p class="text-sm text-yamagata-silver">Qty: {{ $item->quantity }}</p>
                    </div>
                    <span class="font-semibold text-yamagata-black dark:text-white">{{ $item->formatted_price }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-yamagata-pearl/50 dark:border-yamagata-graphite/50 pt-6 mt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-yamagata-silver">Subtotal</span>
                    <span class="text-yamagata-black dark:text-white">${{ number_format($order->subtotal, 0) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-yamagata-silver">Shipping</span>
                    <span class="text-yamagata-black dark:text-white">{{ $order->shipping_cost > 0 ? '$' . number_format($order->shipping_cost, 0) : 'Free' }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-yamagata-pearl/50 dark:border-yamagata-graphite/50">
                    <span class="text-yamagata-black dark:text-white">Total</span>
                    <span class="text-yamagata-red">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <a href="{{ route('shop.index') }}" class="btn-primary inline-flex">
                Continue Shopping
            </a>
            <p class="text-sm text-yamagata-silver">
                Questions? Contact us via
                <a href="{{ config('site.contact.telegram') }}" target="_blank" class="text-yamagata-red hover:underline">Telegram</a>
                or
                <a href="{{ config('site.contact.whatsapp') }}" target="_blank" class="text-yamagata-red hover:underline">WhatsApp</a>
            </p>
        </div>
    </div>
</section>

@endsection
