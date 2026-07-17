@extends('admin.layouts.admin')
@section('title', 'Customers')
@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Customers</span>
@endsection
@section('admin-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-display font-bold text-white">Customers</h1>
        <p class="text-yamagata-silver text-sm mt-0.5">{{ number_format($customers->total()) }} customers</p>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            @if($customers->count())
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                        <th>Loyalty</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>
                            <span class="text-white text-sm font-medium">{{ $customer->name }}</span>
                        </td>
                        <td class="text-sm">{{ $customer->email }}</td>
                        <td class="text-sm">{{ $customer->orders_count ?? 0 }}</td>
                        <td class="text-sm text-white font-medium">${{ number_format($customer->total_spent ?? 0, 0) }}</td>
                        <td>
                            @php $level = $customer->loyalty_level ?? 'none'; @endphp
                            <span class="admin-badge admin-badge-{{ $level }}">{{ ucfirst($level) }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="px-3 py-1.5 text-xs font-medium text-yamagata-mist hover:text-white hover:bg-yamagata-charcoal rounded-lg transition-all">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                <p class="text-yamagata-silver">No customers yet</p>
            </div>
            @endif
        </div>
        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-yamagata-graphite/40">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
