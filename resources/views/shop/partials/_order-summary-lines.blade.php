{{-- Order Summary Lines (Alpine-reactive) --}}
@props(['product' => null])

<div class="space-y-4">
    {{-- Product --}}
    @if($product)
    <div class="flex items-center gap-4">
        <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
        <div class="flex-1 min-w-0">
            <p class="font-medium text-yamagata-black dark:text-white truncate text-sm">{{ $product->name }}</p>
            <p class="text-xs text-yamagata-silver">{{ $product->category->name ?? 'Collection' }}</p>
        </div>
        <span class="font-semibold text-yamagata-black dark:text-white text-sm shrink-0" x-text="'$' + ({{ $product->price }} * quantity)"></span>
    </div>
    @else
    <div class="flex items-center gap-3 text-sm text-yamagata-silver">
        <div class="w-16 h-16 bg-yamagata-snow dark:bg-yamagata-charcoal rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 text-yamagata-pearl dark:text-yamagata-graphite" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <span x-text="selectedProductId ? 'Product selected' : 'Select a product...'"></span>
    </div>
    @endif

    <div class="border-t border-yamagata-pearl/50 dark:border-yamagata-graphite/50 pt-4 space-y-3">
        <div class="flex justify-between text-sm">
            <span class="text-yamagata-silver">Quantity</span>
            <span class="text-yamagata-black dark:text-white font-medium" x-text="quantity"></span>
        </div>
        <div class="flex justify-between text-sm">
            <span class="text-yamagata-silver">Subtotal</span>
            @if($product)
            <span class="text-yamagata-black dark:text-white font-medium" x-text="'$' + ({{ $product->price }} * quantity)"></span>
            @else
            <span class="text-yamagata-silver">—</span>
            @endif
        </div>
        <div class="flex justify-between text-sm">
            <span class="text-yamagata-silver">Shipping</span>
            <span class="text-green-600 dark:text-green-400 font-medium text-xs">Free for CIS</span>
        </div>
        <div class="border-t border-yamagata-pearl/50 dark:border-yamagata-graphite/50 pt-3">
            <div class="flex justify-between items-baseline">
                <span class="font-semibold text-yamagata-black dark:text-white">Total</span>
                @if($product)
                <span class="text-xl font-bold text-yamagata-red" x-text="'$' + ({{ $product->price }} * quantity)"></span>
                @else
                <span class="text-xl font-bold text-yamagata-silver">—</span>
                @endif
            </div>
        </div>
    </div>
</div>
