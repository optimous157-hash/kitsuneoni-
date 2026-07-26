@extends('admin.layouts.admin')

@section('admin-content')

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Orders
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Order {{ $order->reference_number }}</h1>
        </div>
        <div class="flex gap-3">
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf @method('PUT')
                <select name="status" onchange="this.form.submit()" class="input-premium text-sm py-2">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Timeline -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Status</h2>
                <div class="flex items-center gap-4">
                    <span class="admin-badge-{{ $order->status }} text-sm px-4 py-2">{{ $order->status_label }}</span>
                    <span class="text-sm text-yamagata-silver">Updated {{ $order->updated_at->diffForHumans() }}</span>
                </div>
                <div class="grid grid-cols-4 gap-4 mt-6">
                    @foreach(['confirmed', 'processing', 'delivered', 'cancelled'] as $status)
                    <div class="text-center">
                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $order->{$status . '_at'} ? 'bg-green-500/20 text-green-400' : 'bg-yamagata-charcoal text-yamagata-steel' }}">
                            @if($order->{$status . '_at'})
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @else
                            <span class="text-xs">—</span>
                            @endif
                        </div>
                        <p class="text-xs text-yamagata-silver mt-2 capitalize">{{ $status }}</p>
                        @if($order->{$status . '_at'})
                        <p class="text-xs text-yamagata-steel">{{ $order->{$status . '_at'}->format('M d, H:i') }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Items -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-yamagata-charcoal/50 rounded-xl">
                        @if($item->product_image)
                        <img src="{{ asset('storage/' . $item->product_image) }}" class="w-16 h-16 rounded-lg object-cover" alt="">
                        @endif
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ $item->product_name }}</p>
                            <p class="text-sm text-yamagata-silver">Qty: {{ $item->quantity }} �  ${{ number_format($item->unit_price, 0) }}</p>
                            @if($item->variant)
                            <p class="text-xs text-yamagata-steel">Variant: {{ $item->variant }}</p>
                            @endif
                        </div>
                        <span class="text-white font-semibold">${{ number_format($item->total_price, 0) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-2">Customer Notes</h2>
                <p class="text-yamagata-silver">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Summary -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-yamagata-silver">Subtotal</span>
                        <span class="text-white">${{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-yamagata-silver">Shipping</span>
                        <span class="text-white">{{ $order->shipping_cost > 0 ? '$' . number_format($order->shipping_cost, 0) : 'Free' }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-3 border-t border-yamagata-graphite/50">
                        <span class="text-white">Total</span>
                        <span class="text-yamagata-red">${{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Customer</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-yamagata-silver">Name</p>
                        <p class="text-white">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Email</p>
                        <p class="text-white">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Phone</p>
                        <p class="text-white">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Country</p>
                        <p class="text-white">{{ $order->customer_country }}</p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">City</p>
                        <p class="text-white">{{ $order->customer_city }}</p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Address</p>
                        <p class="text-white">{{ $order->customer_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Meta -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Details</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-yamagata-silver">Placed</p>
                        <p class="text-white">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">IP Address</p>
                        <p class="text-white font-mono text-xs">{{ $order->ip_address ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
