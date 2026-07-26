@extends('layouts.app')

@section('title', 'Wishlist — Kitsuneoni')
@section('description', 'Save your favorite Kitsuneoni blades and collectibles to your wishlist for later.')
@section('og_title', 'Wishlist — Kitsuneoni')
@section('og_description', 'Save your favorite Kitsuneoni blades and collectibles to your wishlist.')

@section('content')
<section class="py-16 md:py-24 lg:py-32" x-data>
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="mb-12">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Your Collection</p>
            <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground">Wishlist</h1>
        </div>

        <!-- Empty State -->
        <div x-show="$store.wishlist.count === 0" class="text-center py-24">
            <svg class="w-16 h-16 text-muted-foreground/30 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <h2 class="font-heading text-2xl font-light text-foreground mb-4">Your wishlist is empty</h2>
            <p class="text-sm text-muted-foreground mb-8 max-w-md mx-auto">Browse our collection and save the pieces that speak to you.</p>
            <a href="{{ route('shop.index') }}" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                Explore the Collection
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <!-- Wishlist Items -->
        <div x-show="$store.wishlist.count > 0">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <template x-for="item in $store.wishlist.items" :key="item.id">
                    <div class="group relative">
                        <a :href="item.url" class="block">
                            <div class="relative aspect-[4/5] overflow-hidden bg-card border border-border">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-cover transition-transform duration-[800ms] ease-out group-hover:scale-105" loading="lazy">
                                <div class="absolute inset-0 bg-background/85 backdrop-blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                                    <div class="text-[11px] tracking-[0.2em] uppercase text-primary">View Piece &rarr;</div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h3 class="font-heading text-lg font-light text-foreground group-hover:text-primary transition-colors duration-300" x-text="item.name"></h3>
                                <span class="font-mono text-sm text-foreground mt-2 block" x-text="item.price"></span>
                            </div>
                        </a>
                        <button @click="$store.wishlist.toggle(item)" class="absolute top-4 right-4 z-10 w-11 h-11 flex items-center justify-center rounded-full bg-background/60 backdrop-blur-md transition-all duration-300 hover:bg-background/90 hover:scale-110" aria-label="Remove from wishlist">
                            <svg class="w-4 h-4 text-primary fill-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                    </div>
                </template>
            </div>
            <div class="mt-12 flex justify-center">
                <button @click="$store.wishlist.clear()" class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground transition-colors">
                    Clear Wishlist
                </button>
            </div>
        </div>
    </div>
</section>
@endsection