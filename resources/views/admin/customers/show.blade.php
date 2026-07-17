@extends('admin.layouts.admin')
@section('title', $customer->name)
@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<a href="{{ route('admin.customers.index') }}" class="text-yamagata-silver hover:text-white transition-colors">Customers</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">{{ $customer->name }}</span>
@endsection
@section('admin-content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Customers
            </a>
            <h1 class="text-2xl font-display font-bold text-white">{{ $customer->name }}</h1>
        </div>
        @php $level = $customer->loyalty_level ?? 'none'; @endphp
        <span class="admin-badge admin-badge-{{ $level }} text-sm px-3 py-1.5">{{ ucfirst($level) }} Loyalty</span>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="admin-stat">
            <p class="text-xs text-yamagata-silver uppercase tracking-wide">Total Orders</p>
            <p class="text-2xl font-bold text-white mt-1.5">{{ $customer->orders_count ?? $customer->orders->count() }}</p>
        </div>
        <div class="admin-stat">
            <p class="text-xs text-yamagata-silver uppercase tracking-wide">Total Spent</p>
            <p class="text-2xl font-bold text-white mt-1.5">${{ number_format($customer->total_spent ?? $customer->orders->sum('total'), 0) }}</p>
        </div>
        <div class="admin-stat">
            <p class="text-xs text-yamagata-silver uppercase tracking-wide">Member Since</p>
            <p class="text-lg font-bold text-white mt-2">{{ $customer->created_at->format('M Y') }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Contact Info -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2>Contact</h2>
            </div>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-yamagata-steel text-xs mb-0.5">Email</p>
                    <p class="text-white">{{ $customer->email }}</p>
                </div>
                <div>
                    <p class="text-yamagata-steel text-xs mb-0.5">Phone</p>
                    <p class="text-white">{{ $customer->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-yamagata-steel text-xs mb-0.5">Address</p>
                    <p class="text-white">{{ $customer->address ?? '—' }}{{ $customer->city ? ', ' . $customer->city : '' }}{{ $customer->country ? ', ' . $customer->country : '' }}</p>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="lg:col-span-2 admin-card">
            <div class="admin-card-header">
                <h2>Order History</h2>
            </div>
            <div class="overflow-x-auto">
                @if($customer->orders->count())
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-yamagata-red hover:text-yamagata-red-light font-mono text-xs font-medium">
                                    {{ $order->reference_number }}
                                </a>
                            </td>
                            <td class="text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="admin-badge admin-badge-{{ $order->status }}">{{ $order->status_label }}</span>
                            </td>
                            <td class="text-right text-white font-medium text-sm">${{ number_format($order->total, 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-sm text-yamagata-steel text-center py-6">No orders yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
