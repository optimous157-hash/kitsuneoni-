@extends('admin.layouts.admin')

@section('title', 'Message from ' . $contact->name . ' — Kitsuneoni Admin')

@section('admin-content')

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.contacts.index') }}" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Messages
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Message from {{ $contact->name }}</h1>
        </div>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger text-sm">Delete</button>
        </form>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Message</h2>
                <div class="prose prose-invert max-w-none">
                    <p class="text-yamagata-pearl leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Details</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-yamagata-steel uppercase tracking-wider">Name</dt>
                        <dd class="text-sm text-white mt-0.5">{{ $contact->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-yamagata-steel uppercase tracking-wider">Email</dt>
                        <dd class="text-sm mt-0.5"><a href="mailto:{{ $contact->email }}" class="text-yamagata-red hover:underline">{{ $contact->email }}</a></dd>
                    </div>
                    @if($contact->subject)
                    <div>
                        <dt class="text-xs text-yamagata-steel uppercase tracking-wider">Subject</dt>
                        <dd class="text-sm text-white mt-0.5">{{ $contact->subject }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-xs text-yamagata-steel uppercase tracking-wider">Received</dt>
                        <dd class="text-sm text-white mt-0.5">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-yamagata-steel uppercase tracking-wider">Status</dt>
                        <dd class="mt-0.5">
                            @if($contact->status === 'unread')
                            <span class="admin-badge admin-badge-pending">Unread</span>
                            @else
                            <span class="admin-badge admin-badge-delivered">Read</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Quick Reply</h2>
                <p class="text-sm text-yamagata-silver mb-3">Send a reply to {{ $contact->name }}:</p>
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?: 'Contact Form Message' }}" class="btn-primary w-full text-center text-sm py-3">
                    Reply via Email
                </a>
            </div>
        </div>
    </div>
</div>

@endsection