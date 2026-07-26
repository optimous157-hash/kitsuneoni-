@extends('admin.layouts.admin')

@section('title', 'Contact Messages — Kitsuneoni Admin')

@section('admin-content')

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Contact Messages</h1>
            <p class="text-sm text-yamagata-silver mt-1">{{ $submissions->total() }} total messages</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('admin.contacts.index') }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ !request('status') ? 'bg-yamagata-red/20 text-yamagata-red' : 'text-yamagata-silver hover:text-white bg-yamagata-charcoal' }} transition-all">All</a>
            <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ request('status') === 'unread' ? 'bg-yamagata-red/20 text-yamagata-red' : 'text-yamagata-silver hover:text-white bg-yamagata-charcoal' }} transition-all">
                Unread
                @if($unreadCount > 0)
                <span class="ml-1 px-1.5 py-0.5 bg-yamagata-red/30 text-yamagata-red text-[10px] rounded-full">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ request('status') === 'read' ? 'bg-yamagata-red/20 text-yamagata-red' : 'text-yamagata-silver hover:text-white bg-yamagata-charcoal' }} transition-all">Read</a>
        </div>

        @if($submissions->count())
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                    <tr class="{{ $submission->status === 'unread' ? 'bg-yamagata-red/5' : '' }}">
                        <td class="font-medium text-white">{{ $submission->name }}</td>
                        <td><a href="mailto:{{ $submission->email }}" class="text-yamagata-red hover:underline">{{ $submission->email }}</a></td>
                        <td>{{ $submission->subject ?: '(no subject)' }}</td>
                        <td class="text-yamagata-silver text-xs">{{ $submission->created_at->format('M j, Y g:i A') }}</td>
                        <td>
                            @if($submission->status === 'unread')
                            <span class="admin-badge admin-badge-pending">Unread</span>
                            @else
                            <span class="admin-badge admin-badge-delivered">Read</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.contacts.show', $submission) }}" class="btn-secondary text-xs py-1.5 px-3">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $submissions->links() }}
        </div>
        @else
        <div class="admin-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p>No messages found.</p>
        </div>
        @endif
    </div>
</div>

@endsection