@extends('admin.layouts.admin')

@section('title', 'Products')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Products</span>
@endsection

@section('admin-content')

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Products</h1>
            <p class="text-yamagata-silver text-sm mt-1">{{ number_format($products->total()) }} products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary text-sm px-5 py-2.5">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="input-premium text-sm py-2 max-w-xs">
            <select name="category_id" class="input-premium text-sm py-2 max-w-xs">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary text-sm px-4 py-2">Filter</button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="admin-card overflow-x-auto">
        @if($products->count())
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->primary_image_url }}" class="w-12 h-12 rounded-lg object-cover" alt="">
                    </td>
                    <td>
                        <div>
                            <p class="text-white text-sm font-medium">{{ $product->name }}</p>
                            <div class="flex gap-2 mt-1">
                                @if($product->is_featured)
                                <span class="text-xs text-yamagata-gold">Featured</span>
                                @endif
                                @if($product->is_new)
                                <span class="text-xs text-yamagata-red">New</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-yamagata-silver font-mono text-xs">{{ $product->sku ?? '—' }}</td>
                    <td class="text-sm">{{ $product->category->name ?? '—' }}</td>
                    <td class="text-white font-semibold text-sm">${{ number_format($product->price, 0) }}</td>
                    <td>
                        <span class="text-sm {{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <span class="admin-badge {{ $product->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                            {{ $product->is_active ? 'Active' : 'Draft' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-sm text-yamagata-red hover:text-yamagata-red-light">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-sm text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">{{ $products->links() }}</div>
        @else
        <p class="text-yamagata-silver text-center py-12">No products found.</p>
        @endif
    </div>
</div>

@endsection
