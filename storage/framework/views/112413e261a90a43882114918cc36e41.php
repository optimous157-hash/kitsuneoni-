<?php $__env->startSection('title', request('category') ? (($cat = $categories->firstWhere('slug', request('category')))?->name ?? 'Shop') . ' — Kitsuneoni' : 'Shop — Kitsuneoni'); ?>
<?php $__env->startSection('description', request('category') ? ($categories->firstWhere('slug', request('category'))?->description ?? 'Browse our collection.') : 'Browse our collection of premium handcrafted Japanese collectibles. Katanas, blades, and artisan works.'); ?>
<?php $__env->startSection('page_json_ld'); ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "<?php echo e(request('category') ? ($categories->firstWhere('slug', request('category'))?->name ?? 'Shop') : 'Shop'); ?> — Kitsuneoni",
    "description": "<?php echo e(request('category') ? ($categories->firstWhere('slug', request('category'))?->description ?? 'Browse our collection.') : 'Browse our collection of premium handcrafted Japanese collectibles.'); ?>",
    "url": "<?php echo e(url()->current()); ?>",
    "brand": { "@type": "Brand", "name": "Kitsuneoni" }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        { "@type": "ListItem", "position": 1, "name": "Home", "item": "<?php echo e(url('/')); ?>" },
        { "@type": "ListItem", "position": 2, "name": "Shop", "item": "<?php echo e(route('shop.index')); ?>" }
        <?php if(request('category')): ?>
        ,{ "@type": "ListItem", "position": 3, "name": "<?php echo e($categories->firstWhere('slug', request('category'))?->name ?? request('category')); ?>", "item": "<?php echo e(url()->current()); ?>" }
        <?php endif; ?>
    ]
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="border-b border-border" x-data="{ filtersOpen: false }">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        
        <nav class="py-4 flex items-center gap-2" aria-label="Breadcrumb">
            <a href="<?php echo e(route('home')); ?>" class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground hover:text-foreground transition-colors">Home</a>
            <span class="text-muted-foreground/40">/</span>
            <span class="text-[11px] tracking-[0.3em] uppercase text-foreground">Shop</span>
            <?php if(request('category')): ?>
                <span class="text-muted-foreground/40">/</span>
                <span class="text-[11px] tracking-[0.3em] uppercase text-primary"><?php echo e($categories->firstWhere('slug', request('category'))?->name ?? request('category')); ?></span>
            <?php endif; ?>
        </nav>

        <div class="flex items-end justify-between pb-10 gap-4">
            <div>
                <h1 class="font-heading text-3xl font-light text-foreground tracking-wide">Shop</h1>
                <p class="text-muted-foreground text-sm mt-2">
                    <?php if(request('category')): ?>
                        <?php echo e($categories->firstWhere('slug', request('category'))?->name ?? 'Collection'); ?> &mdash;
                    <?php endif; ?>
                    <?php echo e($products->total()); ?> <?php echo e(Str::plural('piece', $products->total())); ?> available
                </p>
            </div>

            
            <button @click="filtersOpen = !filtersOpen" class="lg:hidden flex items-center gap-2 px-4 py-2.5 border border-border hover:border-primary/50 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span class="text-[11px] tracking-[0.2em] uppercase">Filters</span>
            </button>
        </div>
    </div>
</section>

<section class="py-10 lg:py-14">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">

        
        <div x-show="filtersOpen" x-collapse class="lg:hidden mb-10">
            <div class="bg-card border border-border p-6 space-y-6">

                
                <div>
                    <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-3">Sort By</label>
                    <form method="GET" action="<?php echo e(route('shop.index')); ?>">
                        <?php if(request('category')): ?>
                        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                        <?php endif; ?>
                        <select name="sort" onchange="this.form.submit()" class="input-premium w-full text-sm py-2.5">
                            <option value="newest" <?php echo e(request('sort', 'newest') === 'newest' ? 'selected' : ''); ?>>Newest</option>
                            <option value="popular" <?php echo e(request('sort') === 'popular' ? 'selected' : ''); ?>>Most Popular</option>
                            <option value="price_asc" <?php echo e(request('sort') === 'price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                            <option value="price_desc" <?php echo e(request('sort') === 'price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
                            <option value="name" <?php echo e(request('sort') === 'name' ? 'selected' : ''); ?>>Name</option>
                        </select>
                    </form>
                </div>

                
                <?php if($categories->count()): ?>
                <div>
                    <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-3">Categories</label>
                    <div class="space-y-1">
                        <a href="<?php echo e(route('shop.index', ['sort' => request('sort')])); ?>"
                           class="flex items-center justify-between px-3 py-2 text-sm transition-all <?php echo e(!request('category') ? 'text-foreground bg-muted' : 'text-muted-foreground hover:text-foreground hover:bg-muted/50'); ?>">
                            <span>All Pieces</span>
                        </a>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('shop.index', ['category' => $cat->slug, 'sort' => request('sort')])); ?>"
                           class="flex items-center justify-between px-3 py-2 text-sm transition-all <?php echo e(request('category') === $cat->slug ? 'text-primary bg-primary/5' : 'text-muted-foreground hover:text-foreground hover:bg-muted/50'); ?>">
                            <span><?php echo e($cat->name); ?></span>
                            <span class="font-mono text-[11px] text-muted-foreground/60"><?php echo e($cat->active_products_count); ?></span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                
                <div>
                    <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-3">Price Range</label>
                    <form method="GET" action="<?php echo e(route('shop.index')); ?>" class="space-y-3">
                        <?php if(request('category')): ?>
                        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                        <?php endif; ?>
                        <?php if(request('sort')): ?>
                        <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
                        <?php endif; ?>
                        <div class="flex gap-3">
                            <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" placeholder="Min" class="input-premium w-full text-sm py-2.5">
                            <span class="text-muted-foreground/40 self-center">&mdash;</span>
                            <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" placeholder="Max" class="input-premium w-full text-sm py-2.5">
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-[#c41e3a] text-white text-[11px] tracking-[0.3em] uppercase font-semibold rounded-lg shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">Apply Filter</button>
                    </form>
                </div>

                <?php if(request('min_price') || request('max_price')): ?>
                <a href="<?php echo e(route('shop.index', array_filter(['category' => request('category'), 'sort' => request('sort')]))); ?>" class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground transition-colors">
                    Clear price filter &times;
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">

            
            <aside class="hidden lg:block w-64 shrink-0">
                <div class="sticky top-28 space-y-8">

                    
                    <div>
                        <form method="GET" action="<?php echo e(route('shop.index')); ?>">
                            <?php if(request('category')): ?>
                            <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                            <?php endif; ?>
                            <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-3">Sort By</label>
                            <select name="sort" onchange="this.form.submit()" class="input-premium w-full text-sm py-2.5">
                                <option value="newest" <?php echo e(request('sort', 'newest') === 'newest' ? 'selected' : ''); ?>>Newest</option>
                                <option value="popular" <?php echo e(request('sort') === 'popular' ? 'selected' : ''); ?>>Most Popular</option>
                                <option value="price_asc" <?php echo e(request('sort') === 'price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                                <option value="price_desc" <?php echo e(request('sort') === 'price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
                                <option value="name" <?php echo e(request('sort') === 'name' ? 'selected' : ''); ?>>Name</option>
                            </select>
                        </form>
                    </div>

                    <div class="h-px bg-border"></div>

                    
                    <?php if($categories->count()): ?>
                    <div>
                        <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-4">Categories</label>
                        <div class="space-y-0.5">
                            <a href="<?php echo e(route('shop.index', ['sort' => request('sort')])); ?>"
                               class="flex items-center justify-between px-3 py-2.5 rounded-lg text-[13px] tracking-wide transition-all <?php echo e(!request('category') ? 'text-foreground bg-muted font-medium' : 'text-muted-foreground hover:text-foreground hover:bg-muted/50'); ?>">
                                <span>All Pieces</span>
                            </a>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('shop.index', ['category' => $cat->slug, 'sort' => request('sort')])); ?>"
                               class="flex items-center justify-between px-3 py-2.5 rounded-lg text-[13px] tracking-wide transition-all <?php echo e(request('category') === $cat->slug ? 'text-primary bg-primary/5 font-medium' : 'text-muted-foreground hover:text-foreground hover:bg-muted/50'); ?>">
                                <span><?php echo e($cat->name); ?></span>
                                <span class="font-mono text-[11px] text-muted-foreground/50"><?php echo e($cat->active_products_count); ?></span>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="h-px bg-border"></div>

                    
                    <div>
                        <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-4">Price Range</label>
                        <form method="GET" action="<?php echo e(route('shop.index')); ?>" class="space-y-4">
                            <?php if(request('category')): ?>
                            <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
                            <?php endif; ?>
                            <?php if(request('sort')): ?>
                            <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
                            <?php endif; ?>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" placeholder="Min" class="input-premium w-full text-sm py-2.5">
                                    <span class="text-muted-foreground/30 text-xs">&mdash;</span>
                                    <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" placeholder="Max" class="input-premium w-full text-sm py-2.5">
                                </div>
                            </div>
                            <button type="submit" class="w-full py-2.5 border border-border bg-card text-foreground text-[11px] tracking-[0.3em] uppercase hover:border-primary/50 hover:text-primary transition-all">
                                Apply
                            </button>
                            <?php if(request('min_price') || request('max_price')): ?>
                            <a href="<?php echo e(route('shop.index', array_filter(['category' => request('category'), 'sort' => request('sort')]))); ?>" class="block text-center text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground transition-colors mt-1">
                                Clear filter &times;
                            </a>
                            <?php endif; ?>
                        </form>
                    </div>

                    
                    <?php if(request('category') || request('min_price') || request('max_price') || (request('sort') && request('sort') !== 'newest')): ?>
                    <div class="h-px bg-border"></div>
                    <div>
                        <label class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground block mb-3">Active Filters</label>
                        <div class="flex flex-wrap gap-2">
                            <?php if(request('category')): ?>
                            <a href="<?php echo e(route('shop.index', array_filter(['sort' => request('sort')]))); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary text-[11px] tracking-wide">
                                <?php echo e($categories->firstWhere('slug', request('category'))?->name ?? request('category')); ?>

                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                            <?php endif; ?>
                            <?php if(request('min_price') || request('max_price')): ?>
                            <a href="<?php echo e(route('shop.index', array_filter(['category' => request('category'), 'sort' => request('sort')]))); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary text-[11px] tracking-wide">
                                $<?php echo e(request('min_price', '0')); ?> &mdash; $<?php echo e(request('max_price', '∞')); ?>

                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('shop.index', array_filter(['category' => request('category')]))); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-border text-muted-foreground text-[11px] tracking-wide hover:text-foreground hover:border-foreground/30 transition-colors">
                                Clear all
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </aside>

            
            <div class="flex-1 min-w-0">
                <?php if($products->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-6 gap-y-10">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('shop.partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <?php if($products->hasPages()): ?>
                <div class="mt-16 pt-10 border-t border-border">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground">
                            Showing <?php echo e($products->firstItem()); ?>&ndash;<?php echo e($products->lastItem()); ?> of <?php echo e($products->total()); ?>

                        </p>
                        <nav class="flex items-center gap-1">
                            <?php if($products->onFirstPage()): ?>
                            <span class="w-10 h-10 flex items-center justify-center text-muted-foreground/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </span>
                            <?php else: ?>
                            <a href="<?php echo e($products->previousPageUrl()); ?>" class="w-10 h-10 flex items-center justify-center text-muted-foreground hover:text-foreground border border-border hover:border-primary/50 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            </a>
                            <?php endif; ?>

                            <?php $__currentLoopData = $products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($url); ?>" class="w-10 h-10 flex items-center justify-center font-mono text-sm transition-all <?php echo e($page === $products->currentPage() ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:text-foreground border border-border hover:border-primary/50'); ?>">
                                <?php echo e($page); ?>

                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if($products->currentPage() < $products->lastPage()): ?>
                            <a href="<?php echo e($products->nextPageUrl()); ?>" class="w-10 h-10 flex items-center justify-center text-muted-foreground hover:text-foreground border border-border hover:border-primary/50 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <?php else: ?>
                            <span class="w-10 h-10 flex items-center justify-center text-muted-foreground/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
                <?php endif; ?>

                <?php else: ?>
                
                <div class="flex flex-col items-center justify-center py-28 text-center">
                    
                    <div class="relative w-24 h-24 mb-8">
                        <div class="absolute inset-0 border border-border/60 rotate-45 rounded-sm"></div>
                        <div class="absolute inset-3 border border-border/40 rotate-45 rounded-sm"></div>
                        <div class="absolute inset-6 border border-border/20 rotate-45"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-8 h-8 text-muted-foreground/40" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>

                    <h3 class="font-heading text-2xl font-light text-foreground mb-3">No pieces found</h3>
                    <p class="text-muted-foreground text-sm max-w-sm leading-relaxed mb-8">
                        Your current filters returned no results. Try broadening your search or browse our full collection.
                    </p>
                    <a href="<?php echo e(route('shop.index')); ?>" class="inline-flex items-center gap-2 px-8 py-3 bg-[#c41e3a] text-white text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                        View All Pieces
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\products.blade.php ENDPATH**/ ?>