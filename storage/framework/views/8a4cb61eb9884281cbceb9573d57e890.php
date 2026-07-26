<?php $__env->startSection('title', 'Kitsuneoni — Premium Handcrafted Japanese Blades'); ?>
<?php $__env->startSection('description', 'Collector-grade katanas, swords, and knives. Forged by hand. Shipped worldwide.'); ?>
<?php $__env->startSection('og_image', asset('storage/brand/kitsuneoni-og.jpg')); ?>
<?php $__env->startSection('page_json_ld'); ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "Kitsuneoni",
    "url": "<?php echo e(url('/')); ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo e(url('/search')); ?>?q={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "<?php echo e(url('/')); ?>"
    }]
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Carousel -->
<section class="relative h-screen min-h-[500px] md:min-h-[700px] flex items-center justify-center overflow-hidden"
         x-data="heroCarousel()" x-init="init()">

    <!-- Slides (static brand images, independent from products) -->
    <?php $heroes = [
        0 => ['src' => 'storage/brand/hero-1.jpg', 'alt' => 'Elegant handcrafted katana display'],
        1 => ['src' => 'storage/brand/hero-2.jpg', 'alt' => 'Premium Japanese blade craftsmanship'],
        2 => ['src' => 'storage/brand/hero-3.jpg', 'alt' => 'Collector-grade samurai sword'],
        3 => ['src' => 'storage/brand/hero-4.jpg', 'alt' => 'Traditional katana with intricate details'],
        4 => ['src' => 'storage/brand/hero-5.jpg', 'alt' => 'Hand-forged Japanese longsword'],
    ]; ?>
    <?php $__currentLoopData = $heroes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $hero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="absolute inset-0"
         x-show="current === <?php echo e($idx); ?>"
         x-transition:enter="transition-opacity duration-[1500ms] ease-in-out"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-[1500ms] ease-in-out"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <img src="<?php echo e(asset($hero['src'])); ?>" alt="<?php echo e($hero['alt']); ?>"
             class="w-full h-full object-cover" loading="<?php echo e($idx === 0 ? 'eager' : 'lazy'); ?>">
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Overlays -->
    <div class="absolute inset-0 bg-gradient-to-b from-background/40 via-background/50 to-background z-20"></div>
    <div class="absolute inset-0 bg-background/30 z-20"></div>

    <!-- Content -->
    <div class="relative z-30 text-center px-6 max-w-4xl">
        <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-6">
            Kitsuneoni
        </p>
        <h1 class="font-heading text-6xl md:text-7xl lg:text-8xl xl:text-9xl font-light leading-[0.9] text-balance text-foreground">
            Lethal<br><em class="font-light">Elegance</em>
        </h1>
        <p class="text-sm md:text-base text-muted-foreground mt-8 max-w-xl mx-auto leading-relaxed">
            Japanese blades, made the old way. No machines, just fire and steel. Shipped to your door.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
            <a href="<?php echo e(route('shop.index')); ?>" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center gap-2">
                Explore the Collection
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="<?php echo e(route('shop.index')); ?>" class="border border-border text-foreground px-8 py-4 text-[11px] tracking-[0.3em] uppercase hover:border-primary hover:text-primary transition-colors">
                View Katanas
            </a>
        </div>
    </div>

    <!-- Bottom collection quick-links bar -->
    <?php if($categories->count()): ?>
    <?php $catCount = min($categories->count(), 3); ?>
    <div class="absolute bottom-0 left-0 right-0 z-30">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 pb-8">
            <div class="glass border border-border/50 grid grid-cols-2 sm:grid-cols-<?php echo e($catCount); ?> divide-x divide-border/50">
                <?php $__currentLoopData = $categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('shop.index', ['category' => $cat->slug])); ?>" class="flex items-center justify-center py-4 px-4 text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground hover:bg-primary/5 transition-all duration-300">
                    <?php echo e($cat->name); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Slide indicators -->
    <div class="absolute bottom-20 left-1/2 -translate-x-1/2 z-30 flex items-center gap-3" x-show="loaded">
        <template x-for="(slide, idx) in count" :key="'dot-'+idx">
            <button @click="goTo(idx)"
                    class="transition-all duration-500 rounded-full"
                    :class="current === idx ? 'w-8 h-2 bg-primary' : 'w-2 h-2 bg-muted-foreground/30 hover:bg-muted-foreground/50'"
                    :aria-label="'Slide ' + (idx + 1)"></button>
        </template>
    </div>
</section>

<script>
function heroCarousel() {
    return {
        current: 0,
        loaded: false,
        timer: null,
        count: 5,
        init() {
            setTimeout(() => { this.loaded = true; }, 100);
            this.startTimer();
        },
        startTimer() {
            clearInterval(this.timer);
            this.timer = setInterval(() => this.next(), 6000);
        },
        next() {
            this.current = (this.current + 1) % this.count;
            this.startTimer();
        },
        prev() {
            this.current = (this.current - 1 + this.count) % this.count;
            this.startTimer();
        },
        goTo(idx) {
            this.current = idx;
            this.startTimer();
        }
    }
}
</script>

<!-- Featured Products (Most Coveted) -->
<?php if($featuredProducts->count()): ?>
<section class="py-16 md:py-24 lg:py-32 border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-12">
            <div>
                <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Curated Selection</p>
                <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground">Most Coveted</h2>
            </div>
            <a href="<?php echo e(route('shop.index')); ?>" class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground transition-colors">
                View All &rarr;
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('shop.partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Craftsmanship (two-column) -->
<section id="craft" class="py-16 md:py-24 lg:py-32 border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Our Philosophy</p>
                <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-8 text-balance">The Art of<br>Japanese Craftsmanship</h2>
                <div class="space-y-4 text-muted-foreground leading-relaxed text-sm">
                    <p>There's no assembly line here. Just a hammer, an anvil, and someone who's spent years learning how to use them right. Every piece we make starts as raw steel and gets shaped by hand — no CNC, no shortcuts.</p>
                    <p>We follow the old ways because they work. <em class="text-foreground font-medium">Ichigo Ichie</em> — every strike matters because you only get one chance to make it count. That's not a slogan, it's how we work.</p>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-10">
                    <?php $__currentLoopData = [['Carbon Steel', 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'], ['Handcrafted', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'], ['Worldwide Delivery', 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'], ['Verified Quality', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $path]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo e($path); ?>"/></svg>
                        </div>
                        <span class="text-sm text-foreground"><?php echo e($label); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <a href="<?php echo e(route('about')); ?>" class="inline-flex items-center gap-2 mt-10 bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                    Learn More &rarr;
                </a>
            </div>
            <div class="relative">
                <div class="aspect-[4/5] overflow-hidden relative">
                    <img src="<?php echo e(asset('storage/brand/Craftsmanship1.png')); ?>" alt="Japanese craftsmanship"
                         class="w-full h-full object-cover transition-transform duration-[800ms] hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-background/40 via-transparent to-transparent pointer-events-none"></div>
                </div>
                <div class="absolute -bottom-6 -left-6 glass border border-border/50 p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                            <span class="font-japanese text-lg text-foreground">&#x953C;</span>
                        </div>
                        <div>
                            <p class="text-sm text-foreground">Forged by Hand</p>
                            <p class="text-xs text-muted-foreground">Since 2019</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Best Sellers -->
<?php if($bestsellers->count()): ?>
<section class="py-16 md:py-24 lg:py-32 border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-12">
            <div>
                <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Most Loved</p>
                <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground">Best Sellers</h2>
            </div>
            <a href="<?php echo e(route('shop.index', ['sort' => 'popular'])); ?>" class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground transition-colors">
                View All &rarr;
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $bestsellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('shop.partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- New Arrivals -->
<?php if($newArrivals->count()): ?>
<section class="py-16 md:py-24 lg:py-32 border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-12">
            <div>
                <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Fresh Steel</p>
                <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground">New Arrivals</h2>
            </div>
            <a href="<?php echo e(route('shop.index', ['sort' => 'newest'])); ?>" class="text-[11px] tracking-[0.2em] uppercase text-muted-foreground hover:text-foreground transition-colors">
                View All &rarr;
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('shop.partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Testimonials -->
<?php if($testimonials->count()): ?>
<section class="py-16 md:py-24 lg:py-32 border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Collector Voices</p>
            <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground">What They Say</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-card border border-border p-8">
                <div class="flex gap-1 mb-4">
                    <?php for($i = 0; $i < $testimonial->rating; $i++): ?>
                    <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <?php endfor; ?>
                </div>
                <p class="font-heading text-lg font-light italic text-muted-foreground leading-relaxed mb-6">&ldquo;<?php echo e($testimonial->body); ?>&rdquo;</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-primary/10 rounded-full flex items-center justify-center">
                        <span class="text-xs font-bold text-primary"><?php echo e(substr($testimonial->customer_name, 0, 1)); ?></span>
                    </div>
                    <div>
                        <p class="text-sm text-foreground"><?php echo e($testimonial->customer_name); ?></p>
                        <?php if($testimonial->customer_title): ?>
                        <p class="text-[11px] text-muted-foreground"><?php echo e($testimonial->customer_title); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ -->
<?php if($faqs->count()): ?>
<section id="faq" class="py-16 md:py-24 lg:py-32 border-t border-border">
    <div class="max-w-2xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-12">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Questions</p>
            <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground">Frequently Asked</h2>
        </div>
        <div class="space-y-0" x-data="{ openFaq: null }">
            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border-b border-border">
                <button @click="openFaq === <?php echo e($faq->id); ?> ? openFaq = null : openFaq = <?php echo e($faq->id); ?>" class="w-full flex items-center justify-between py-6 text-left">
                    <span class="font-heading text-lg font-light text-foreground pr-4"><?php echo e($faq->question); ?></span>
                    <svg class="w-4 h-4 text-muted-foreground shrink-0 transition-transform duration-300" :class="openFaq === <?php echo e($faq->id); ?> ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openFaq === <?php echo e($faq->id); ?>" x-collapse>
                    <div class="pb-6 text-sm text-muted-foreground leading-relaxed">
                        <?php echo $faq->answer; ?>

                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="py-16 md:py-24 lg:py-32 border-t border-border text-center">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Ready?</p>
        <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-6 text-balance">Ready to wield legendary steel?</h2>
        <p class="text-sm text-muted-foreground max-w-lg mx-auto mb-10 leading-relaxed">Took a look around? If something catches your eye, it's yours. We'll get it to you, wherever you are.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(route('shop.index')); ?>" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                Browse Collection
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="<?php echo e(route('order.create')); ?>" class="border border-border text-foreground px-8 py-4 text-[11px] tracking-[0.3em] uppercase hover:border-primary hover:text-primary transition-colors">
                Order Now
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\home.blade.php ENDPATH**/ ?>