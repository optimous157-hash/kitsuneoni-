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
    $hasVideo = !empty($product->video_file) || (!empty($product->video_url) && str_starts_with($product->video_url, 'http'));
    $videoSource = !empty($product->video_file) ? asset('storage/' . $product->video_file) : $product->video_url;

    $specPills = [];
    if ($product->steel_type) $specPills[] = ['label' => 'Steel', 'value' => $product->steel_type];
    if ($product->construction) $specPills[] = ['label' => 'Construction', 'value' => $product->construction];
    if ($product->hardness_hrc) $specPills[] = ['label' => 'Hardness', 'value' => $product->hardness_hrc . ' HRC'];
    if ($product->material && $product->material !== $product->steel_type) $specPills[] = ['label' => 'Material', 'value' => $product->material];
    if ($product->overall_length) $specPills[] = ['label' => 'Length', 'value' => $product->overall_length . ' cm'];
@endphp

<div class="pt-20 min-h-screen bg-background">

    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-6">
        <nav class="flex items-center gap-2 text-xs text-muted-foreground overflow-x-auto">
            <a href="{{ route('home') }}" class="hover:text-foreground transition-colors whitespace-nowrap">Home</a>
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('shop.index') }}" class="hover:text-foreground transition-colors whitespace-nowrap">Collection</a>
            @if($product->category)
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-foreground transition-colors whitespace-nowrap">{{ $product->category->name }}</a>
            @endif
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            <span class="text-foreground whitespace-nowrap truncate">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- Product Grid --}}
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 pb-24">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">

            {{-- LEFT: Image Gallery --}}
            <div x-data="{
                activeImage: 0,
                lightbox: false,
                showVideo: false,
                images: @js($galleryImages),
                hasVideo: {{ $hasVideo ? 'true' : 'false' }},
                get total() { return this.images.length + (this.hasVideo ? 1 : 0); },
                get currentLabel() { return this.showVideo ? this.total : this.activeImage + 1; },
                handleError(el) { el.style.display='none'; el.nextElementSibling.style.display='flex'; },
                handleThumbError(el) { el.classList.add('opacity-30'); },
                navigate(dir) {
                    if (this.showVideo) {
                        if (dir === -1) { this.showVideo = false; this.activeImage = this.images.length - 1; }
                        else if (dir === 1 && this.lightbox) { this.showVideo = false; this.activeImage = 0; }
                        return;
                    }
                    if (dir === 1) {
                        if (this.activeImage < this.images.length - 1) { this.activeImage++; }
                        else if (this.hasVideo) { this.showVideo = true; }
                        else if (this.lightbox) { this.activeImage = 0; }
                    } else if (dir === -1) {
                        if (this.activeImage > 0) { this.activeImage--; }
                        else if (this.hasVideo && this.lightbox) { this.showVideo = true; }
                        else if (this.lightbox) { this.activeImage = this.images.length - 1; }
                    }
                }
            }" @keydown.left.window="navigate(-1)" @keydown.right.window="navigate(1)" @keydown.escape.window="lightbox = false">

                {{-- Main Image (Square) / Video --}}
                <div x-show="!showVideo" class="relative aspect-square bg-card overflow-hidden cursor-pointer group rounded-2xl border border-border" @click="lightbox = true">
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

                    {{-- Zoom overlay on hover --}}
                    <div class="absolute top-4 right-4 px-3 py-2 bg-background/60 backdrop-blur-md border border-border/30 rounded-xl flex items-center gap-2 text-xs text-foreground opacity-0 group-hover:opacity-100 transition-opacity z-10">
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

                {{-- Video Player (in same aspect-square frame) --}}
                @if($hasVideo)
                <div x-show="showVideo" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="relative aspect-square bg-card overflow-hidden rounded-2xl border border-border">
                    @if(str_contains($videoSource, 'youtube.com') || str_contains($videoSource, 'youtu.be'))
                    <iframe src="{{ str_replace('watch?v=', 'embed/', $videoSource) }}" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @elseif(str_contains($videoSource, 't.me') || str_contains($videoSource, 'telegram.me'))
                    <iframe src="{{ $videoSource }}" class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
                    @else
                    <video controls poster="{{ $product->primary_image_url }}" class="absolute inset-0 w-full h-full object-contain">
                        <source src="{{ $videoSource }}">
                    </video>
                    @endif
                    <button @click="showVideo = false" class="absolute top-4 right-4 z-10 px-3 py-2 bg-background/60 backdrop-blur-md border border-border/30 rounded-xl text-xs text-foreground hover:text-primary transition-colors">
                        Back to images
                    </button>
                </div>
                @endif

                {{-- Thumbnails (80x80) --}}
                @if($product->images->count() > 1 || $hasVideo)
                <div class="flex gap-2.5 mt-4 overflow-x-auto pb-1">
                    @foreach($product->images as $index => $img)
                    <button @click="activeImage = {{ $index }}; showVideo = false" :class="activeImage === {{ $index }} && !showVideo ? 'border-primary' : 'border-transparent opacity-60 hover:opacity-100'" class="flex-shrink-0 w-20 h-20 overflow-hidden border-2 transition-all rounded-xl">
                        <img src="{{ $img->url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" x-on:error="handleThumbError($el)">
                    </button>
                    @endforeach
                    @if($hasVideo)
                    <button @click="showVideo = true; activeImage = -1" :class="showVideo ? 'border-primary' : 'border-transparent opacity-60 hover:opacity-100'" class="flex-shrink-0 w-20 h-20 overflow-hidden border-2 transition-all rounded-xl relative">
                        <div class="w-full h-full bg-muted flex items-center justify-center">
                            <svg class="w-7 h-7 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                        <span class="absolute bottom-0.5 left-0.5 text-[8px] text-primary-foreground bg-primary/80 rounded px-1 py-px">Video</span>
                    </button>
                    @endif
                </div>
                @endif

                {{-- Lightbox --}}
                <div x-show="lightbox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-xl flex items-center justify-center p-4" @click="lightbox = false">
                    <button class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 text-white hover:bg-white/20 transition-colors" @click.stop="lightbox = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <img x-show="!showVideo" :src="images[activeImage]" @click.stop class="max-w-full max-h-[85vh] object-contain rounded-2xl" x-on:error="handleError($el)">
                    @if($hasVideo)
                    <div x-show="showVideo" @click.stop class="max-w-full max-h-[85vh] w-full flex items-center justify-center">
                        @if(str_contains($videoSource, 'youtube.com') || str_contains($videoSource, 'youtu.be'))
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $videoSource) }}" class="w-full h-full max-w-[85vh] aspect-square" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @elseif(str_contains($videoSource, 't.me') || str_contains($videoSource, 'telegram.me'))
                        <iframe src="{{ $videoSource }}" class="w-full h-full max-w-[85vh] aspect-square" frameborder="0" allowfullscreen></iframe>
                        @else
                        <video controls poster="{{ $product->primary_image_url }}" class="max-w-full max-h-[85vh] object-contain">
                            <source src="{{ $videoSource }}">
                        </video>
                        @endif
                    </div>
                    @endif
                    @if($product->images->count() > 1 || $hasVideo)
                    <button @click.stop="navigate(-1)" class="absolute left-4 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click.stop="navigate(1)" class="absolute right-4 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @endif
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                        <span x-text="currentLabel + ' / ' + total"></span>
                        <span class="text-white/50 ml-2">← → to navigate</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Product Info (sticky) --}}
            <div class="lg:sticky lg:top-28 h-fit">

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
                <h1 class="font-heading text-4xl lg:text-5xl font-light leading-tight text-foreground mb-4">{{ $product->name }}</h1>

                {{-- Short Description --}}
                @if($product->short_description)
                <p class="text-muted-foreground leading-relaxed mb-8">{{ $product->short_description }}</p>
                @endif

                {{-- Regional Pricing --}}
                <div class="border border-border p-6 mb-8 rounded-xl">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-muted-foreground mb-4">Regional Pricing</p>
                    <div class="grid grid-cols-3 divide-x divide-border">
                        <div class="text-center px-2">
                            <p class="text-[9px] tracking-wider uppercase text-muted-foreground mb-1">CIS</p>
                            <p class="font-mono text-lg text-foreground">{{ number_format($product->price, 0) }} ?</p>
                        </div>
                        <div class="text-center px-2">
                            <p class="text-[9px] tracking-wider uppercase text-muted-foreground mb-1">EU / AM</p>
                            <p class="font-mono text-lg text-primary">${{ number_format($product->price, 0) }}</p>
                        </div>
                        <div class="text-center px-2">
                            <p class="text-[9px] tracking-wider uppercase text-muted-foreground mb-1">AF / AU</p>
                            <p class="font-mono text-lg text-foreground">${{ number_format($product->price, 0) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Spec Pills --}}
                @if(count($specPills) > 0)
                <div class="flex flex-wrap gap-2 mb-6">
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
                <div class="flex items-center gap-2.5 mb-6">
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

                {{-- Telegram / WhatsApp --}}
                <div class="flex gap-3 mb-6">
                    <a href="{{ config('site.contact.telegram') }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 bg-muted border border-border hover:bg-accent hover:border-primary/50 text-foreground text-xs font-medium rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        Telegram
                    </a>
                    <a href="{{ config('site.contact.whatsapp') }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 py-3 px-4 bg-muted border border-border hover:bg-accent hover:border-primary/50 text-foreground text-xs font-medium rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                </div>
                @endif

                {{-- Stock & SKU --}}
                <div class="flex items-center gap-2 text-xs text-muted-foreground mb-8">
                    <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    @if($product->in_stock)
                    <span>{{ $product->stock }} in stock</span>
                    @else
                    <span>Made to order</span>
                    @endif
                    @if($product->sku)
                    <span class="ml-auto font-mono">SKU: {{ $product->sku }}</span>
                    @endif
                </div>

                {{-- Trust Row --}}
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-border">
                    <div class="text-center">
                        <svg class="w-5 h-5 mx-auto text-primary mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-[9px] tracking-wider uppercase text-muted-foreground">Worldwide Shipping</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-5 h-5 mx-auto text-primary mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg>
                        <p class="text-[9px] tracking-wider uppercase text-muted-foreground">Hand-Forged</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-5 h-5 mx-auto text-primary mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-.53.53a4.5 4.5 0 006.364 0l2.122-2.122a4.5 4.5 0 000-6.364l-2.122-2.122a4.5 4.5 0 00-6.364 0l-.53.53m-2.122 2.122l-2.121 2.122a4.5 4.5 0 000 6.364l2.122 2.122a4.5 4.5 0 006.364 0l2.122-2.122a4.5 4.5 0 000-6.364l-2.122-2.122a4.5 4.5 0 00-6.364 0z"/></svg>
                        <p class="text-[9px] tracking-wider uppercase text-muted-foreground">Full Tang</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ==================== DESCRIPTION ==================== --}}
        @if($product->description)
        <div class="mt-24 max-w-3xl">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">The Piece</p>
            <h2 class="font-heading text-3xl lg:text-4xl font-light text-foreground mb-6">Description</h2>
            <div class="text-muted-foreground leading-relaxed [&_p]:mb-4 [&_strong]:text-foreground [&_strong]:font-medium">
                {!! $product->description !!}
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
        <div class="mt-24">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Technical Details</p>
            <h2 class="font-heading text-3xl lg:text-4xl font-light text-foreground mb-8">Steel &amp; Soul</h2>
            <div class="border border-border rounded-xl overflow-hidden">
                <table class="w-full">
                    <tbody>
                        @foreach($allSpecs as $index => [$label, $value])
                        <tr class="{{ $index < count($allSpecs) - 1 ? 'border-b border-border' : '' }}">
                            <td class="py-4 px-6 text-[10px] tracking-[0.2em] uppercase text-muted-foreground w-1/3 align-top">{{ $label }}</td>
                            <td class="py-4 px-6 font-mono text-sm text-foreground">{{ $value }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- ==================== SHIPPING INFO ==================== --}}
        <div class="mt-16 border border-border p-8 rounded-xl">
            <h3 class="font-heading text-2xl font-light text-foreground mb-4">Shipping Information</h3>
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

        {{-- ==================== REVIEWS ==================== --}}
        @if($product->reviews->count())
        <div class="mt-24 pt-12 border-t border-border">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="font-heading text-3xl lg:text-4xl font-light text-foreground">Collector Reviews</h2>
                    <p class="text-xs text-muted-foreground mt-1">{{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-bold text-foreground">{{ $product->average_rating }}</span>
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $product->average_rating ? 'text-yamagata-gold' : 'text-muted-foreground/30' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                @foreach($product->reviews as $review)
                <div class="bg-card border border-border rounded-xl p-6">
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
                    <div class="flex items-center gap-2 mt-4 pt-3 border-t border-border">
                        <span class="text-xs font-medium text-foreground">{{ $review->customer_name }}</span>
                        @if($review->customer_country)
                        <span class="text-xs text-muted-foreground">· {{ $review->customer_country }}</span>
                        @endif
                        <span class="text-xs text-muted-foreground">· {{ $review->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ==================== RELATED PRODUCTS ==================== --}}
        @if($related->count())
        <div class="mt-24 pt-12 border-t border-border">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-3">You May Also Like</p>
                    <h2 class="font-heading text-3xl lg:text-4xl font-light text-foreground">Related Pieces</h2>
                </div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($related as $rp)
                @include('shop.partials.product-card', ['product' => $rp])
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
