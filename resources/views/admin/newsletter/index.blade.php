@extends('admin.layouts.admin')
@section('title', 'Newsletter')
@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Newsletter</span>
@endsection
@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Newsletter</h1>
            <p class="text-yamagata-silver text-sm mt-0.5">{{ number_format($subscribers->total()) }} subscribers</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            @if($subscribers->count())
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $sub)
                    <tr>
                        <td>
                            <span class="text-white text-sm font-medium">{{ $sub->email }}</span>
                        </td>
                        <td class="text-sm">{{ $sub->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="admin-badge {{ $sub->is_active ? 'admin-badge-active' : 'admin-badge-draft' }}">
                                {{ $sub->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <form action="{{ route('admin.newsletter.destroy', $sub) }}" method="POST" class="inline" onsubmit="return confirm('Remove this subscriber?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 text-xs font-medium text-yamagata-silver hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <p class="text-yamagata-silver">No subscribers yet</p>
            </div>
            @endif
        </div>
        @if($subscribers->hasPages())
        <div class="px-6 py-4 border-t border-yamagata-graphite/40">
            {{ $subscribers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
