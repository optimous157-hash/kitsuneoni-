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

<div class="border-b border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-8">
        <nav class="flex items-center gap-2 text-xs text-muted-foreground mb-4 overflow-x-auto">
            @foreach($breadcrumbs as $bc)
                @if($bc['url'])
                <a href="{{ $bc['url'] }}" class="hover:text-foreground transition-colors whitespace-nowrap">{{ $bc['label'] }}</a>
                <span class="text-muted-foreground/40">/</span>
                @else
                <span class="text-foreground font-medium whitespace-nowrap">{{ $bc['label'] }}</span>
                @endif
            @endforeach
        </nav>
        <h1 class="font-heading text-3xl md:text-4xl font-light text-foreground">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-muted-foreground text-sm mt-2">{{ $category->description }}</p>
        @endif
    </div>
</div>

<section class="py-12">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        @if($products->count())
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
            @include('shop.partials.product-card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-20">
            <p class="text-muted-foreground text-lg">No products found in this category.</p>
            <a href="{{ route('shop.index') }}" class="mt-6 inline-flex items-center gap-2 bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">Browse All Products</a>
        </div>
        @endif
    </div>
</section>

@endsection
