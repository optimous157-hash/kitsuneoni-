@extends('layouts.app')

@section('title', $category->meta_title ?: $category->name . ' — Kitsuneoni')
@section('description', $category->meta_description ?: $category->description)
@section('og_title', $category->meta_title ?: $category->name)
@section('og_description', $category->meta_description ?: $category->description)
@section('page_json_ld')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "{{ $category->name }} — Kitsuneoni",
    "description": "{{ $category->meta_description ?: $category->description }}",
    "url": "{{ url()->current() }}",
    "brand": { "@@type": "Brand", "name": "Kitsuneoni" }
}
</script>
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
        { "@@type": "ListItem", "position": 2, "name": "Shop", "item": "{{ route('shop.index') }}" },
        { "@@type": "ListItem", "position": 3, "name": "{{ $category->name }}", "item": "{{ url()->current() }}" }
    ]
}
</script>
@endsection

@section('content')

<div class="bg-yamagata-snow dark:bg-yamagata-dark border-b border-yamagata-pearl/30 dark:border-yamagata-graphite/30 py-8">
    <div class="container-premium">
        <nav class="flex items-center gap-2 text-sm text-yamagata-silver mb-4">
            @foreach($breadcrumbs as $bc)
                @if($bc['url'])
                <a href="{{ $bc['url'] }}" class="hover:text-yamagata-red transition-colors">{{ $bc['label'] }}</a>
                <span>/</span>
                @else
                <span class="text-yamagata-black dark:text-white font-medium">{{ $bc['label'] }}</span>
                @endif
            @endforeach
        </nav>
        <h1 class="text-3xl md:text-4xl font-display font-bold text-yamagata-black dark:text-white">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-yamagata-silver mt-2">{{ $category->description }}</p>
        @endif
    </div>
</div>

<section class="py-12">
    <div class="container-premium">
        @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <p class="text-yamagata-silver text-lg">No products found in this category.</p>
            <a href="{{ route('shop.index') }}" class="mt-4 inline-block btn-primary">Browse All Products</a>
        </div>
        @endif
    </div>
</section>

@endsection
