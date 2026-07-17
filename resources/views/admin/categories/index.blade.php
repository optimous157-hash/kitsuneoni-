@extends('admin.layouts.admin')
@section('title', 'Categories')
@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Dashboard
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Categories</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary px-5 py-2.5 text-sm">
            + New Category
        </a>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-yamagata-graphite/50">
                        <th class="text-left px-6 py-3 font-medium text-yamagata-silver">Name</th>
                        <th class="text-left px-6 py-3 font-medium text-yamagata-silver">Slug</th>
                        <th class="text-left px-6 py-3 font-medium text-yamagata-silver">Parent</th>
                        <th class="text-left px-6 py-3 font-medium text-yamagata-silver">Products</th>
                        <th class="text-left px-6 py-3 font-medium text-yamagata-silver">Sort</th>
                        <th class="text-right px-6 py-3 font-medium text-yamagata-silver">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-yamagata-graphite/30">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-yamagata-charcoal/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-white">{{ $cat->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-yamagata-silver font-mono text-xs">{{ $cat->slug }}</td>
                        <td class="px-6 py-4 text-yamagata-silver">{{ $cat->parent?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-yamagata-mist">{{ $cat->products_count ?? 0 }}</td>
                        <td class="px-6 py-4 text-yamagata-mist">{{ $cat->sort_order }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="px-3 py-1.5 text-xs font-medium text-yamagata-mist hover:text-white hover:bg-yamagata-charcoal rounded-lg transition-all">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category and all its subcategories?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 text-xs font-medium text-yamagata-silver hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="text-yamagata-graphite mb-3">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <p class="text-yamagata-silver mb-2">No categories yet</p>
                            <a href="{{ route('admin.categories.create') }}" class="text-sm text-yamagata-red hover:text-yamagata-red-light transition-colors">Create your first category →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-yamagata-graphite/50">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
