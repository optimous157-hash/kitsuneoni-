@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' — Kitsuneoni')
@section('description', $product->meta_description ?: $product->short_description)
@section('og_title', $product->meta_title ?: $product->name)
@section('og_description', $product->meta_description ?: $product->short_description)
@section('og_image', $product->primary_image_url)

@php
    $productLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'description' => strip_tags($product->short_description ?? $product->description),
        'image' => $product->primary_image_url,
        'brand' => ['@type' => 'Brand', 'name' => 'Kitsuneoni'],
        'offers' => [
            '@type' => 'Offer',
            'price' => $product->price,
            'priceCurrency' => 'USD',
            'availability' => $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'seller' => ['@type' => 'Organization', 'name' => 'Kitsuneoni'],
        ],
    ];
    if ($product->reviews_count > 0) {
        $productLd['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $product->average_rating,
            'reviewCount' => $product->reviews_count,
        ];
    }
@endphp
@section('page_json_ld')
<script type="application/ld+json">
{!! json_encode($productLd, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

@php
    $galleryImages = $product->images->map(fn($img) => $img->url)->values()->toArray();

    $specPills = [];
    if ($product->steel_type) $specPills[] = ['label' => 'Steel', 'value' => $product->steel_type];
    if ($product->construction) $specPills[] = ['label' => 'Construction', 'value' => $product->construction];
    if ($product->hardness_hrc) $specPills[] = ['label' => 'Hardness', 'value' => $product->hardness_hrc . ' HRC'];
    if ($product->material && $product->material !== $product->steel_type) $specPills[] = ['label' => 'Material', 'value' => $product->material];
    if ($product->overall_length) $specPills[] = ['label' => 'Length', 'value' => $product->overall_length . ' cm'];
@endphp

<div class="pt-20 min-h-screen bg-background">

    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-12 py-4 sm:py-6">
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] text-muted-foreground">
            <a href="{{ route('home') }}" class="hover:text-foreground transition-colors">Home</a>
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('shop.index') }}" class="hover:text-foreground transition-colors">Collection</a>
            @if($product->category)
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-foreground transition-colors">{{ $product->category->name }}</a>
            @endif
            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-foreground max-w-[200px] truncate">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- Product Grid --}}
    <div class="max-w-[1440px] mx-auto w-full px-4 sm:px-6 lg:px-12 pb-28 lg:pb-24">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16">

            {{-- LEFT: Image Gallery --}}
            <div class="min-w-0" x-data="{
                activeImage: 0,
                lightbox: false,
                imgLoading: false,
                imgError: false,
                images: @js($galleryImages),
                get total() { return this.images.length; },
                get currentLabel() { return this.activeImage + 1; },
                handleError(el) { el.style.display='none'; if (el.nextElementSibling?.classList.contains('img-fallback')) el.nextElementSibling.style.display='flex'; },
                handleThumbError(el) { el.classList.add('opacity-30'); },
                navigate(dir) {
                    this.imgLoading = true;
                    this.imgError = false;
                    if (dir === 1) {
                        if (this.activeImage < this.images.length - 1) { this.activeImage++; }
                        else if (this.lightbox) { this.activeImage = 0; }
                    } else if (dir === -1) {
                        if (this.activeImage > 0) { this.activeImage--; }
                        else if (this.lightbox) { this.activeImage = this.images.length - 1; }
                    }
                },
                openLightbox() {
                    this.lightbox = true;
                    this.imgError = false;
                    const src = this.images[this.activeImage] || @js($product->primary_image_url);
                    if (!src) { this.imgLoading = false; return; }
                    const probe = new Image();
                    if (probe.complete === undefined) { this.imgLoading = true; }
                    probe.onload = () => { this.imgLoading = false; };
                    probe.onerror = () => { this.imgError = true; this.imgLoading = false; };
                    probe.src = src;
                    if (probe.complete && probe.naturalWidth > 0) { this.imgLoading = false; }
                    else { this.imgLoading = true; }
                }
            }" @keydown.left.window="navigate(-1)" @keydown.right.window="navigate(1)" @keydown.escape.window="lightbox = false">

                {{-- Main Image --}}
                <div class="relative w-full sm:aspect-square bg-card overflow-hidden cursor-pointer group rounded-2xl border border-border max-sm:h-[55vw]" @click="openLightbox()">
                    <img
                        :src="images[activeImage] || @js($product->primary_image_url)"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
                        loading="eager"
                        x-on:error="handleError($el)"
                    >
                    <div class="absolute inset-0 img-fallback hidden flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-muted-foreground/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-muted-foreground">Image unavailable</p>
                    </div>

                    {{-- Zoom overlay --}}
                    <div class="absolute top-4 right-4 px-3 py-2 bg-background/60 backdrop-blur-md border border-border/30 rounded-xl flex items-center gap-2 text-xs text-foreground lg:opacity-0 lg:group-hover:opacity-100 transition-opacity z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6"/></svg>
                        Zoom
                    </div>

                    {{-- Badges --}}
                    @if($product->is_new || $product->is_bestseller || $product->discount_percent)
                    <div class="absolute top-4 left-4 flex gap-2 z-10">
                        @if($product->is_new)
                        <span class="px-3 py-1 bg-primary/90 backdrop-blur-md text-primary-foreground text-[11px] font-semibold tracking-wider uppercase rounded-full">New</span>
                        @endif
                        @if($product->is_bestseller)
                        <span class="px-3 py-1 bg-yamagata-gold/20 backdrop-blur-md text-yamagata-gold text-[11px] font-semibold tracking-wider uppercase rounded-full">Bestseller</span>
                        @endif
                        @if($product->discount_percent)
                        <span class="px-3 py-1 bg-green-500/20 backdrop-blur-md text-green-600 dark:text-green-400 text-[11px] font-semibold tracking-wider uppercase rounded-full">-{{ $product->discount_percent }}%</span>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- Thumbnails (80x80) --}}
                @if($product->images->count() > 1)
                <div class="flex gap-2.5 mt-4 overflow-x-auto pb-1">
                    @foreach($product->images as $index => $img)
                    <button @click="activeImage = {{ $index }}" :class="activeImage === {{ $index }} ? 'border-primary' : 'border-transparent opacity-60 hover:opacity-100'" class="flex-shrink-0 w-14 sm:w-20 h-14 sm:h-20 overflow-hidden border-2 transition-all rounded-xl">
                        <img src="{{ $img->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" x-on:error="handleThumbError($el)">
                    </button>
                    @endforeach
                </div>
                @endif

                {{-- Lightbox --}}
                <div x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-[0.97]" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl flex items-center justify-center p-4" @click="lightbox = false">
                    <button class="absolute top-4 sm:top-6 right-4 sm:right-6 z-10 w-10 h-10 flex items-center justify-center rounded-full bg-white/15 text-white hover:bg-white/25 transition-colors" @click.stop="lightbox = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    {{-- Loading spinner --}}
                    <div x-show="imgLoading" class="flex flex-col items-center justify-center">
                        <svg class="animate-spin h-10 w-10 text-white/50 mb-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <p class="text-white/40 text-xs">Loading image...</p>
                    </div>

                    {{-- Image --}}
                    <img x-show="!imgError" :src="images[activeImage] || @js($product->primary_image_url)" @click.stop
                         class="max-w-full max-h-[85vh] w-auto h-auto object-contain rounded-2xl"
                         :class="imgLoading ? 'opacity-0 absolute' : 'opacity-100 relative'"
                         x-on:load="imgLoading = false; imgError = false"
                         x-on:error="imgError = true; imgLoading = false">

                    {{-- Error fallback --}}
                    <div x-show="imgError" @click.stop class="flex flex-col items-center justify-center text-white/60">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm">Unable to load image</p>
                        <button @click.stop="imgError = false; imgLoading = true" class="mt-3 text-xs text-white/40 hover:text-white/60 underline">Retry</button>
                    </div>

                    @if($product->images->count() > 1)
                    <button @click.stop="navigate(-1)" class="absolute left-3 sm:left-6 w-11 sm:w-12 h-11 sm:h-12 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm">
                        <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click.stop="navigate(1)" class="absolute right-3 sm:right-6 w-11 sm:w-12 h-11 sm:h-12 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm">
                        <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @endif
                    <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 px-3 py-1.5 sm:px-4 sm:py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-[11px] sm:text-xs font-medium flex items-center gap-2">
                        <span x-text="currentLabel + ' / ' + total"></span>
                        <span class="text-white/50 hidden sm:inline">| &#8592; &#8594; navigate</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Product Info (sticky) --}}
            <div class="min-w-0 lg:sticky lg:top-28 h-fit">

                {{-- Badges row --}}
                @if($product->is_new || $product->is_bestseller)
                <div class="flex items-center gap-3 mb-4">
                    @if($product->is_new)
                    <span class="text-[9px] tracking-[0.3em] uppercase text-primary">New</span>
                    @endif
                    @if($product->is_bestseller)
                    <span class="text-[9px] tracking-[0.3em] uppercase text-yamagata-gold">Bestseller</span>
                    @endif
                </div>
                @endif

                {{-- Title --}}
                <h1 class="font-heading text-2xl sm:text-4xl lg:text-5xl font-light leading-tight text-foreground mb-4">{{ $product->name }}</h1>

                {{-- Short Description --}}
                @if($product->short_description)
                <p class="text-muted-foreground leading-relaxed mb-4 sm:mb-8">{{ $product->short_description }}</p>
                @endif

                {{-- Price --}}
                <div class="border border-border p-4 sm:p-6 mb-4 sm:mb-8 rounded-xl">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-muted-foreground mb-4">Price</p>
                    <p class="font-mono text-2xl sm:text-3xl text-primary">${{ number_format($product->price, 0) }} <span class="text-sm text-muted-foreground font-sans">USD</span></p>
                </div>

                {{-- Spec Pills --}}
                @if(count($specPills) > 0)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($specPills as $sp)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-muted border border-border rounded-lg text-[11px]">
                        <span class="text-muted-foreground">{{ $sp['label'] }}</span>
                        <span class="text-foreground font-medium">{{ $sp['value'] }}</span>
                    </span>
                    @endforeach
                </div>
                @endif

                {{-- Rating --}}
                @if($product->average_rating > 0)
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= $product->average_rating ? 'text-yamagata-gold' : 'text-muted-foreground/30' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-xs text-muted-foreground">{{ $product->average_rating }} ({{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }})</span>
                </div>
                @endif

                {{-- Order CTA + Wishlist + Share --}}
                @if($product->in_stock)
                <div class="flex gap-3 mb-4">
                    <a href="{{ route('order.create', ['product_id' => $product->id]) }}"
                       class="flex-1 bg-[#c41e3a] hover:bg-[#9b1830] text-white py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl transition-all duration-300 shadow-[0_0_30px_rgba(196,30,58,0.25)] hover:shadow-[0_0_50px_rgba(196,30,58,0.4)] flex items-center justify-center gap-2">
                        Order Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <button @click="$store.wishlist.toggle({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', slug: '{{ $product->slug }}', price: '${{ number_format($product->price, 0) }}', image: '{{ $product->primary_image_url }}', url: '{{ $product->url }}' })"
                            :class="$store.wishlist.has({{ $product->id }}) ? 'border-primary text-primary' : 'border-border text-muted-foreground hover:border-foreground hover:text-foreground'"
                            class="w-14 h-14 border rounded-xl flex items-center justify-center transition-all shrink-0"
                            aria-label="Toggle wishlist">
                        <svg class="w-5 h-5" :class="$store.wishlist.has({{ $product->id }}) ? 'fill-primary' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                    <button onclick="navigator.share ? navigator.share({title:'{{ addslashes($product->name) }}',url:window.location.href}) : navigator.clipboard.writeText(window.location.href)"
                            class="w-14 h-14 border border-border rounded-xl flex items-center justify-center text-muted-foreground hover:border-foreground hover:text-foreground transition-all shrink-0"
                            aria-label="Share">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/></svg>
                    </button>
                </div>


                @endif

                {{-- Stock & SKU --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 text-xs text-muted-foreground mb-4 sm:mb-8">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        @if($product->in_stock)
                        <span>{{ $product->stock }} in stock</span>
                        @else
                        <span>Made to order</span>
                        @endif
                    </div>
                    @if($product->sku)
                    <span class="font-mono">SKU: {{ $product->sku }}</span>
                    @endif
                </div>

                {{-- Trust Row --}}
                <div class="grid grid-cols-3 gap-2 sm:gap-4 pt-6 border-t border-border">
                    <a href="{{ route('faq') }}" class="text-center group">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-auto text-primary mb-1 sm:mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-[9px] sm:text-[10px] leading-tight tracking-wider uppercase text-muted-foreground group-hover:text-primary transition-colors">Worldwide Shipping</p>
                    </a>
                    <div class="text-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-auto text-primary mb-1 sm:mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
                        <p class="text-[9px] sm:text-[10px] leading-tight tracking-wider uppercase text-muted-foreground">Hand-Forged</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mx-auto text-primary mb-1 sm:mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-.53.53a4.5 4.5 0 006.364 0l2.122-2.122a4.5 4.5 0 000-6.364l-2.122-2.122a4.5 4.5 0 00-6.364 0l-.53.53m-2.122 2.122l-2.121 2.122a4.5 4.5 0 000 6.364l2.122 2.122a4.5 4.5 0 006.364 0l2.122-2.122a4.5 4.5 0 000-6.364l-2.122-2.122a4.5 4.5 0 00-6.364 0z"/></svg>
                        <p class="text-[9px] sm:text-[10px] leading-tight tracking-wider uppercase text-muted-foreground">Full Tang</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ==================== DESCRIPTION (collapsible on mobile) ==================== --}}
        @if($product->description)
        <div x-data="{ descOpen: true }" class="mt-6 md:mt-24 max-w-3xl">
            <button @click="descOpen = !descOpen" type="button" class="flex items-start justify-between w-full text-left group md:cursor-default">
                <div>
                    <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">The Piece</p>
                    <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-light text-foreground">Description</h2>
                </div>
                <svg class="w-5 h-5 text-muted-foreground transition-transform duration-300 shrink-0 mt-2 md:hidden" :class="descOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="descOpen" x-collapse>
                <div class="text-muted-foreground leading-relaxed [&_p]:mb-4 [&_strong]:text-foreground [&_strong]:font-medium mt-4 sm:mt-6">
                    {!! $product->description !!}
                </div>
            </div>
        </div>
        @endif

        {{-- ==================== FULL SPECS ==================== --}}
        @php
            $allSpecs = [];
            if ($product->material) $allSpecs[] = ['Material', $product->material];
            if ($product->steel_type) $allSpecs[] = ['Steel', $product->steel_type];
            if ($product->construction) $allSpecs[] = ['Construction', $product->construction];
            if ($product->hardness_hrc) $allSpecs[] = ['Hardness', $product->hardness_hrc . ' HRC'];
            if ($product->overall_length) $allSpecs[] = ['Overall Length', $product->overall_length . ' cm'];
            if ($product->blade_length) $allSpecs[] = ['Blade Length', $product->blade_length . ' cm'];
            if ($product->blade_width) $allSpecs[] = ['Blade Width', $product->blade_width . ' cm'];
            if ($product->blade_thickness) $allSpecs[] = ['Blade Thickness', $product->blade_thickness . ' cm'];
            if ($product->handle_material) $allSpecs[] = ['Handle', $product->handle_material];
            if ($product->scabbard_material) $allSpecs[] = ['Scabbard', $product->scabbard_material];
            if ($product->weight) $allSpecs[] = ['Weight', $product->weight . 'g'];
        @endphp

        @if(count($allSpecs) > 0)
        <div x-data="{ specsOpen: true }" class="mt-6 md:mt-24">
            <button @click="specsOpen = !specsOpen" type="button" class="flex items-start justify-between w-full text-left group md:cursor-default">
                <div>
                    <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Technical Details</p>
                    <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-light text-foreground">Steel &amp; Soul</h2>
                </div>
                <svg class="w-5 h-5 text-muted-foreground transition-transform duration-300 shrink-0 mt-2 md:hidden" :class="specsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="specsOpen" x-collapse>
                <div class="border border-border rounded-xl overflow-x-auto mt-4 sm:mt-6 md:mt-8">
                    <table class="w-full min-w-0">
                        <tbody>
                            @foreach($allSpecs as $index => [$label, $value])
                            <tr class="{{ $index < count($allSpecs) - 1 ? 'border-b border-border' : '' }}">
                                <td class="py-3 sm:py-4 px-3 sm:px-6 text-[10px] tracking-[0.2em] uppercase text-muted-foreground w-2/5 sm:w-1/3 align-top break-words">{{ $label }}</td>
                                <td class="py-3 sm:py-4 px-3 sm:px-6 font-mono text-sm text-foreground break-words">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- ==================== SHIPPING INFO ==================== --}}
        <div class="mt-6 md:mt-16 border border-border p-4 sm:p-8 rounded-xl">
            <h3 class="font-heading text-xl sm:text-2xl font-light text-foreground mb-3 sm:mb-4">Shipping Information</h3>
            <p class="text-sm text-muted-foreground leading-relaxed mb-4">We ship worldwide to over 40 countries. Each piece is carefully packaged in a protective case to ensure it arrives in pristine condition. Delivery times vary by region:</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="border-l border-border pl-4">
                    <p class="text-[9px] tracking-wider uppercase text-muted-foreground">CIS</p>
                    <p class="font-mono text-sm text-foreground">7-14 days</p>
                </div>
                <div class="border-l border-border pl-4">
                    <p class="text-[9px] tracking-wider uppercase text-muted-foreground">Europe &amp; Americas</p>
                    <p class="font-mono text-sm text-foreground">10-21 days</p>
                </div>
                <div class="border-l border-border pl-4">
                    <p class="text-[9px] tracking-wider uppercase text-muted-foreground">Africa &amp; Australia</p>
                    <p class="font-mono text-sm text-foreground">14-28 days</p>
                </div>
            </div>
        </div>

        {{-- ==================== REVIEWS (collapsible on mobile) ==================== --}}
        @if($product->reviews->count())
        <div x-data="{ reviewsOpen: true }" class="mt-6 md:mt-24 pt-6 md:pt-12 border-t border-border">
            <button @click="reviewsOpen = !reviewsOpen" type="button" class="flex items-start justify-between w-full text-left group md:cursor-default mb-4 md:mb-8">
                <div class="flex items-center gap-4">
                    <div>
                        <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-light text-foreground">Collector Reviews</h2>
                        <p class="text-xs text-muted-foreground mt-1">{{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xl sm:text-2xl font-bold text-foreground">{{ $product->average_rating }}</span>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $product->average_rating ? 'text-yamagata-gold' : 'text-muted-foreground/30' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <svg class="w-5 h-5 text-muted-foreground transition-transform duration-300 shrink-0 md:hidden" :class="reviewsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="reviewsOpen" x-collapse>
                <div class="space-y-4">
                    @foreach($product->reviews as $review)
                    <div class="bg-card border border-border rounded-xl p-4 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex gap-0.5 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yamagata-gold' : 'text-muted-foreground/20' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                @if($review->title)
                                <h4 class="text-sm font-semibold text-foreground mb-1">{{ $review->title }}</h4>
                                @endif
                                <p class="text-sm text-muted-foreground leading-relaxed">{{ $review->body }}</p>
                            </div>
                            @if($review->is_verified)
                            <span class="shrink-0 px-2 py-0.5 bg-green-100 dark:bg-green-500/10 text-green-700 dark:text-green-400 text-[10px] font-semibold rounded uppercase tracking-wider">Verified</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-4 pt-3 border-t border-border">
                            <span class="text-xs font-medium text-foreground">{{ $review->customer_name }}</span>
                            @if($review->customer_country)
                            <span class="text-[11px] text-muted-foreground">· {{ $review->customer_country }}</span>
                            @endif
                            <span class="text-[11px] text-muted-foreground">· {{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ==================== RELATED PRODUCTS ==================== --}}
        @if($related->count())
        <div class="mt-10 md:mt-24 pt-10 md:pt-12 border-t border-border">
            <div class="flex items-end justify-between mb-8 md:mb-12">
                <div>
                    <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-3">You May Also Like</p>
                    <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-light text-foreground">Related Pieces</h2>
                </div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($related as $rp)
                @include('shop.partials.product-card', ['product' => $rp])
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

{{-- Sticky Mobile CTA --}}
<div x-data="{ showSticky: false }" x-init="window.addEventListener('scroll', () => { showSticky = window.scrollY > 500 })" class="fixed bottom-0 left-0 right-0 z-50 bg-background/95 backdrop-blur-lg border-t border-border p-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] lg:hidden transition-all duration-300" :class="showSticky ? 'translate-y-0' : 'translate-y-full'">
    <a href="{{ route('order.create', ['product_id' => $product->id]) }}" class="flex items-center justify-center gap-2 w-full bg-[#c41e3a] text-white py-3.5 rounded-xl text-[11px] tracking-[0.3em] uppercase font-semibold shadow-[0_0_20px_rgba(196,30,58,0.25)] active:scale-[0.98] transition-all duration-300">
        Order Now — ${{ number_format($product->price, 0) }}
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
    </a>
</div>

@endsection
