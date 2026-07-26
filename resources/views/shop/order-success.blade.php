@extends('layouts.app')

@section('title', 'Order Confirmed — Kitsuneoni')
@section('description', 'Your order has been confirmed. We will contact you via email within 24 hours with next steps.')
@section('og_title', 'Order Confirmed — Kitsuneoni')
@section('og_description', 'Your Kitsuneoni order has been confirmed. We will contact you within 24 hours.')

@section('content')

<section class="py-16 md:py-20">
    <div class="max-w-2xl mx-auto px-6 lg:px-12 text-center">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-8">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>

        <h1 class="font-heading text-3xl md:text-4xl font-bold text-foreground mb-4">Order Confirmed!</h1>
        <p class="text-muted-foreground mb-8">Thank you for your order. We'll send you a confirmation email shortly.</p>

        <div class="bg-card border border-border rounded-xl p-6 sm:p-8 text-left mb-8">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs text-muted-foreground">Reference Number</p>
                    <p class="text-base sm:text-lg font-bold text-primary font-mono">{{ $order->reference_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Status</p>
                    <p class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-full text-xs font-medium">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                        {{ $order->status_label }}
                    </p>
                </div>
            </div>

            <div class="border-t border-border pt-6">
                <h3 class="font-semibold text-foreground mb-3">Order Items</h3>
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 py-3">
                    @if($item->product_image)
                    <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-lg object-cover">
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-foreground">{{ $item->product_name }}</p>
                        <p class="text-sm text-muted-foreground">Qty: {{ $item->quantity }}</p>
                    </div>
                    <span class="font-semibold text-foreground shrink-0">{{ $item->formatted_price }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-border pt-6 mt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-muted-foreground">Subtotal</span>
                    <span class="text-foreground">${{ number_format($order->subtotal, 0) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-muted-foreground">Shipping</span>
                    <span class="text-foreground">{{ $order->shipping_cost > 0 ? '$' . number_format($order->shipping_cost, 0) : 'Free' }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-border">
                    <span class="text-foreground">Total</span>
                    <span class="text-primary">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                Continue Shopping
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            <p class="text-sm text-muted-foreground">
                Questions? <a href="{{ route('contact') }}" class="text-primary hover:underline">Contact us</a>.
            </p>
        </div>
    </div>
</section>

@endsection
