@extends('admin.layouts.admin')
@section('title', 'Settings')
@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Settings</span>
@endsection
@section('admin-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-display font-bold text-white">Settings</h1>
        <p class="text-yamagata-silver text-sm mt-0.5">Manage your store configuration</p>
    </div>

    @if($errors->any())
    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl mb-6">
        <ul class="text-sm text-red-400 space-y-1">
            @foreach($errors->all() as $error)
            <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div class="admin-card">
            <div class="admin-card-header">
                <h2>General</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Site Name</label>
                    <input type="text" name="settings[site_name]" value="{{ old('settings.site_name', $settings['site_name'] ?? 'Kitsuneoni') }}" class="input-premium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Tagline</label>
                    <input type="text" name="settings[site_tagline]" value="{{ old('settings.site_tagline', $settings['site_tagline'] ?? '') }}" class="input-premium">
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2>Contact</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Email</label>
                    <input type="email" name="settings[contact_email]" value="{{ old('settings.contact_email', $settings['contact_email'] ?? '') }}" class="input-premium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Phone</label>
                    <input type="text" name="settings[contact_phone]" value="{{ old('settings.contact_phone', $settings['contact_phone'] ?? '') }}" class="input-premium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Telegram</label>
                    <input type="text" name="settings[telegram]" value="{{ old('settings.telegram', $settings['telegram'] ?? '@Yamagataaa') }}" class="input-premium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">WhatsApp</label>
                    <input type="text" name="settings[whatsapp]" value="{{ old('settings.whatsapp', $settings['whatsapp'] ?? '') }}" class="input-premium">
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2>SEO</h2>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Meta Title</label>
                    <input type="text" name="settings[meta_title]" value="{{ old('settings.meta_title', $settings['meta_title'] ?? '') }}" class="input-premium" maxlength="255">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Meta Description</label>
                    <textarea name="settings[meta_description]" rows="3" class="input-premium" maxlength="500">{{ old('settings.meta_description', $settings['meta_description'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary px-8 py-3">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
