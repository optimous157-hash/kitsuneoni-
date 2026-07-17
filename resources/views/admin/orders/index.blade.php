@extends('admin.layouts.admin')

@section('title', 'Orders')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Orders</span>
@endsection

@section('admin-content')

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Orders</h1>
            <p class="text-yamagata-silver text-sm mt-1">{{ number_format($stats['total']) }} total orders</p>
        </div>
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn-secondary text-sm px-5 py-2.5 border-yamagata-graphite text-yamagata-mist">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search orders..." class="input-premium text-sm py-2 max-w-xs">
            <select name="status" class="input-premium text-sm py-2 max-w-xs">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-premium text-sm py-2">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-premium text-sm py-2">
            <button type="submit" class="btn-primary text-sm px-4 py-2">Filter</button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="admin-card overflow-x-auto">
        @if($orders->count())
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Customer</th>
                    <th>Country</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-yamagata-red hover:text-yamagata-red-light font-mono text-xs">
                            {{ $order->reference_number }}
                        </a>
                    </td>
                    <td>
                        <div>
                            <p class="text-white text-sm">{{ $order->customer_name }}</p>
                            <p class="text-xs text-yamagata-silver">{{ $order->customer_email }}</p>
                        </div>
                    </td>
                    <td class="text-sm">{{ $order->customer_country }}</td>
                    <td class="font-semibold text-white text-sm">${{ number_format($order->total, 0) }}</td>
                    <td>
                        <span class="admin-badge-{{ $order->status }}">{{ $order->status_label }}</span>
                    </td>
                    <td class="text-yamagata-silver text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-sm text-yamagata-red hover:text-yamagata-red-light">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @else
        <p class="text-yamagata-silver text-center py-12">No orders found.</p>
        @endif
    </div>
</div>

@endsection
