@extends('admin.layouts.admin')

@section('title', 'Edit: ' . $category->name)

@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Categories
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Edit Category</h1>
        </div>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category and all its subcategories? This cannot be undone.')">
            @csrf @method('DELETE')
            <button class="px-4 py-2 text-sm font-medium text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 rounded-xl transition-all">
                Delete Category
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
        <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
            <ul class="text-sm text-red-400 space-y-1">
                @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Basic Info</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="input-premium" placeholder="auto-generated from name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Description</label>
                            <textarea name="description" class="input-premium" rows="3">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">SEO</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" class="input-premium" maxlength="255">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Meta Description</label>
                            <textarea name="meta_description" class="input-premium" rows="2" maxlength="500">{{ old('meta_description', $category->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Organization</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Parent Category</label>
                            <select name="parent_id" class="input-premium">
                                <option value="">None (top-level)</option>
                                @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="input-premium" min="0">
                        </div>
                        <div class="pt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red">
                                <span class="text-sm text-yamagata-mist">Active (visible on site)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full text-center py-3.5">
                    Save Changes
                </button>

                <a href="{{ route('admin.categories.index') }}" class="block text-center text-sm text-yamagata-silver hover:text-white transition-colors py-2">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
