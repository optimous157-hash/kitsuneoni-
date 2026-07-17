@extends('admin.layouts.admin')
@section('title', 'Reviews')
@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Reviews</span>
@endsection
@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Reviews</h1>
            <p class="text-yamagata-silver text-sm mt-0.5">{{ number_format($reviews->total()) }} total reviews</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            @if($reviews->count())
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>
                            <p class="text-white text-sm font-medium">{{ $review->customer_name }}</p>
                            <p class="text-xs text-yamagata-steel">{{ $review->customer_country }}</p>
                        </td>
                        <td class="text-sm">{{ $review->product->name ?? '—' }}</td>
                        <td>
                            <div class="flex gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yamagata-gold' : 'text-yamagata-graphite' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </td>
                        <td class="text-sm max-w-[200px] truncate">{{ $review->title ?: '—' }}</td>
                        <td>
                            <span class="admin-badge {{ $review->is_approved ? 'admin-badge-active' : 'admin-badge-pending' }}">
                                {{ $review->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1.5 text-xs font-medium text-green-400 hover:text-green-300 hover:bg-green-500/10 rounded-lg transition-all">Approve</button>
                                </form>
                                @endif
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 text-xs font-medium text-yamagata-silver hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <p class="text-yamagata-silver">No reviews yet</p>
            </div>
            @endif
        </div>
        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-yamagata-graphite/40">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
