<article class="group relative" data-animate>
    <a href="{{ $product->url }}" class="block">
        <!-- Image Container -->
        <div class="relative aspect-[4/5] overflow-hidden bg-card border border-border">
            <img
                src="{{ $product->primary_image_url }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transition-transform duration-[800ms] ease-out group-hover:scale-105"
                loading="lazy"
                decoding="async"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="absolute inset-0 img-fallback hidden flex-col items-center justify-center">
                <svg class="w-12 h-12 text-muted-foreground/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>

            <!-- Sharp Swipe Effect -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden z-[5]">
                <div class="absolute top-0 left-0 w-full h-full translate-x-[-120%] group-hover:translate-x-[120%] transition-transform duration-[400ms] ease-out">
                    <div class="absolute inset-y-0 -right-[2px] w-[60%] bg-gradient-to-r from-transparent via-white/10 to-white/25 skew-x-[-20deg]"></div>
                    <div class="absolute inset-y-0 -right-[2px] w-[2px] bg-white/40 shadow-[0_0_12px_rgba(255,255,255,0.3)] skew-x-[-20deg]"></div>
                </div>
            </div>

            <!-- Specs Overlay on Hover -->
            <div class="absolute inset-0 bg-background/85 backdrop-blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                @if($product->material)
                <div class="space-y-2">
                    @if($product->steel_type)
                    <div class="flex justify-between border-b border-border/50 pb-2">
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-muted-foreground">Steel</span>
                        <span class="font-mono text-[11px] text-foreground">{{ $product->steel_type }}</span>
                    </div>
                    @endif
                    @if($product->overall_length)
                    <div class="flex justify-between border-b border-border/50 pb-2">
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-muted-foreground">Length</span>
                        <span class="font-mono text-[11px] text-foreground">{{ $product->overall_length }}cm</span>
                    </div>
                    @endif
                    @if($product->hardness_hrc)
                    <div class="flex justify-between border-b border-border/50 pb-2">
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-muted-foreground">Hardness</span>
                        <span class="font-mono text-[11px] text-foreground">HRC {{ $product->hardness_hrc }}</span>
                    </div>
                    @endif
                    @if($product->weight)
                    <div class="flex justify-between">
                        <span class="font-mono text-[10px] tracking-[0.2em] uppercase text-muted-foreground">Weight</span>
                        <span class="font-mono text-[11px] text-foreground">{{ $product->weight }}g</span>
                    </div>
                    @endif
                </div>
                @endif
                <div class="mt-4 text-[11px] tracking-[0.2em] uppercase text-primary">View Piece &rarr;</div>
            </div>

            <!-- Badges -->
            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                @if($product->is_new)
                <span class="text-[9px] tracking-[0.3em] uppercase text-primary-foreground bg-background/60 backdrop-blur-md px-3 py-1">New</span>
                @endif
                @if($product->is_bestseller)
                <span class="text-[9px] tracking-[0.3em] uppercase text-primary-foreground bg-primary/90 backdrop-blur-md px-3 py-1">Bestseller</span>
                @endif
                @if($product->discount_percent)
                <span class="text-[9px] tracking-[0.3em] uppercase text-primary-foreground bg-green-600/90 backdrop-blur-md px-3 py-1">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            <!-- Wishlist Button -->
            <button @click.prevent.stop="$store.wishlist.toggle({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', slug: '{{ $product->slug }}', price: '{{ $product->formatted_price }}', image: '{{ $product->primary_image_url }}', url: '{{ $product->url }}' })" class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-background/60 backdrop-blur-md transition-all duration-300 hover:bg-background/90 hover:scale-110" aria-label="Toggle wishlist">
                <svg class="w-4 h-4 transition-colors duration-300" :class="$store.wishlist.has({{ $product->id }}) ? 'text-primary fill-primary' : 'text-muted-foreground'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </button>
        </div>

        <!-- Content -->
        <div class="mt-4">
            <h3 class="font-heading text-lg font-light text-foreground group-hover:text-primary transition-colors duration-300">{{ $product->name }}</h3>
            <div class="flex items-center gap-3 mt-2">
                <span class="font-mono text-sm text-foreground">{{ $product->formatted_price }}</span>
                @if($product->compare_at_price && $product->compare_at_price > $product->price)
                <span class="font-mono text-sm text-muted-foreground line-through">${{ number_format($product->compare_at_price, 0) }}</span>
                @endif
            </div>
            <span class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground mt-2 block group-hover:text-primary transition-colors duration-300">View Piece &rarr;</span>
        </div>
    </a>
</article>