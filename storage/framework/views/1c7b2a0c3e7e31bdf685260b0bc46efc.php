<?php $__env->startSection('title', 'About — Kitsuneoni'); ?>
<?php $__env->startSection('description', 'Discover Kitsuneoni Workshop — where centuries-old Japanese craftsmanship meets modern precision. Every piece handforged from carbon steel, premium wood, full-grain leather, and custom resin.'); ?>
<?php $__env->startSection('og_title', 'About Kitsuneoni — Handcrafted Blades'); ?>
<?php $__env->startSection('og_description', 'Discover Kitsuneoni Workshop — centuries-old Japanese craftsmanship meets modern precision. Every piece handforged.'); ?>
<?php $__env->startSection('page_json_ld'); ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "About Kitsuneoni",
    "description": "Discover Kitsuneoni Workshop — where centuries-old Japanese craftsmanship meets modern precision.",
    "url": "<?php echo e(url()->current()); ?>",
    "mainEntity": { "@type": "Organization", "name": "Kitsuneoni" }
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<section class="relative min-h-[80vh] flex items-center bg-background overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-background via-primary/5 to-primary/[0.07]"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 select-none pointer-events-none">
        <span class="font-japanese text-[28rem] md:text-[36rem] leading-none text-primary/[0.03]">鬼</span>
    </div>
    <div class="relative max-w-[1440px] mx-auto px-6 lg:px-12 text-center">
        <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">Est. Workshop</p>
        <div class="flex items-center justify-center gap-4 md:gap-8 mb-8">
            <span class="font-japanese text-6xl md:text-8xl text-primary/80">鬼</span>
            <span class="font-japanese text-6xl md:text-8xl text-foreground/60">工房</span>
        </div>
        <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-6 leading-[1.1]">
            Where Steel Meets<br class="hidden sm:block"><span class="text-primary"> Soul</span>
        </h1>
        <p class="text-sm text-muted-foreground max-w-2xl mx-auto mb-12 leading-relaxed">
            Steel, wood, leather, resin. All shaped by hand in a workshop that doesn't believe in shortcuts.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo e(route('shop.index')); ?>" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                Explore Collection
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="#our-story" class="border border-border text-foreground px-8 py-4 text-[11px] tracking-[0.3em] uppercase hover:border-primary hover:text-primary transition-colors">
                Our Story
            </a>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-background to-transparent"></div>
</section>


<section id="our-story" class="py-16 md:py-24 lg:py-32 bg-background border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-start">
            <div>
                <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Our Story</span>
                <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-8">Born from a Flame,<br>Shaped by Hand</h2>
                <div class="space-y-5 text-sm text-muted-foreground leading-relaxed">
                    <p>It started in a backyard shed with more fire than sense. A guy who couldn't stop thinking about steel — how it moves, how it folds, how it changes when you treat it right. What came out of that shed wasn't pretty, but it was real. And that was the start.</p>
                    <p>Over the years we learned from people who knew what they were doing. Spent time watching smiths who'd been at it longer than we'd been alive. Picked up what worked, dropped what didn't. The hammer still talks — you just have to learn to listen.</p>
                    <div class="py-5 px-6 border-l-2 border-primary bg-primary/5">
                        <p class="font-heading text-lg italic text-foreground">
                            "Ichigo Ichie — <span class="text-primary">one time, one meeting</span>. Every piece we forge will never be replicated."
                        </p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <?php $__currentLoopData = [
                    ['icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z', 'title' => 'The Forge', 'desc' => 'Steel goes in red-hot, comes out shaped by hand. No robots, no presets — just someone who knows what they\'re doing.'],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Ichigo Ichie', 'desc' => 'Every piece is its own thing. Once it\'s done, it\'s done — we don\'t make copies. You get the only one.'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Handmade, Not Machine-Made', 'desc' => 'One piece can take days or weeks. We don\'t rush. If you want fast, there are factories for that.'],
                    ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Worldwide Delivery', 'desc' => 'We ship everywhere. Gift box, tracking, the whole deal. Your piece gets to you in one piece.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass p-6 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 flex-shrink-0 bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo e($card['icon']); ?>"/></svg>
                        </div>
                        <div>
                            <h3 class="font-heading text-lg font-medium text-foreground mb-1"><?php echo e($card['title']); ?></h3>
                            <p class="text-sm text-muted-foreground leading-relaxed"><?php echo e($card['desc']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>


<section class="py-16 md:py-24 lg:py-32 bg-card border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
            <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Our Process</span>
            <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-6">Five Steps. One Masterpiece.</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8">
            <?php $__currentLoopData = [
                ['num' => '01', 'title' => 'Material', 'desc' => 'Steel, wood, leather. We pick what works and skip what doesn\'t.', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                ['num' => '02', 'title' => 'Forging', 'desc' => 'Heat it, hit it, shape it. The old way. No CNC, no shortcuts.', 'icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'],
                ['num' => '03', 'title' => 'Polishing', 'desc' => 'Grit by grit, pass by pass, until the steel talks back.', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0'],
                ['num' => '04', 'title' => 'Finishing', 'desc' => 'Handle goes on, leather gets stitched, resin gets poured. By hand, start to finish.', 'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z'],
                ['num' => '05', 'title' => 'Quality Check', 'desc' => 'If it\'s not right, it doesn\'t ship. Simple as that.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="text-center">
                <div class="mx-auto w-16 h-16 bg-primary/10 flex items-center justify-center mb-4 transition-transform duration-500 group-hover:scale-110">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo e($step['icon']); ?>"/></svg>
                </div>
                <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-1 block">Step <?php echo e($step['num']); ?></span>
                <h3 class="font-heading text-base font-medium text-foreground mb-1"><?php echo e($step['title']); ?></h3>
                <p class="text-xs text-muted-foreground leading-relaxed"><?php echo e($step['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="py-16 md:py-24 lg:py-32 bg-background border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
            <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Materials</span>
            <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-6">Only the Finest</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__currentLoopData = [
                ['title' => 'Carbon Steel', 'desc' => '1045 high-carbon. Forged, polished, hardened. Gets better with age if you take care of it.', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                ['title' => 'Premium Woods', 'desc' => 'Oak, zebrawood, ebony. Each handle is shaped to sit right in your hand. No two feel exactly the same.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['title' => 'Full-Grain Leather', 'desc' => 'Vegetable-tanned, hand-sewn. Ages like a good boot. Gets better the more you use it.', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['title' => 'Custom Resin', 'desc' => 'Epoxy, hand-poured. Amber, black, or whatever color works. Every pour turns out different — that\'s the point.', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="glass p-8 group">
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 flex-shrink-0 bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo e($mat['icon']); ?>"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading text-lg font-medium text-foreground mb-2"><?php echo e($mat['title']); ?></h3>
                        <p class="text-sm text-muted-foreground leading-relaxed"><?php echo e($mat['desc']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="relative py-16 md:py-24 lg:py-32 bg-background overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/80 via-primary to-primary/90"></div>
    <div class="relative max-w-[1440px] mx-auto px-6 lg:px-12 text-center max-w-3xl mx-auto">
        <span class="font-japanese text-7xl md:text-9xl text-white/10 block mb-8">鬼</span>
        <h2 class="font-heading text-4xl lg:text-5xl font-light text-white mb-6 leading-tight">Ready to Own a Masterpiece?</h2>
        <p class="text-sm text-white/70 max-w-xl mx-auto mb-12 leading-relaxed">
            Everything here is made when you order it. No warehouses, no stockpiles. Just your piece, made right, sent your way.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="<?php echo e(route('order.create')); ?>" class="bg-white text-foreground px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(255,255,255,0.15)] hover:bg-white/90 hover:shadow-[0_0_35px_rgba(255,255,255,0.25)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                Place Your Order
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="<?php echo e(route('faq')); ?>" class="border border-white/20 text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase hover:border-white/50 hover:text-white transition-colors">
                Learn More
            </a>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 mt-12 pt-8 border-t border-white/15">
            <?php $__currentLoopData = ['100% Handcrafted', 'Worldwide Delivery', 'Premium Gift Case', 'Loyalty Rewards']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="flex items-center gap-2 text-xs text-white/70">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?php echo e($badge); ?>

            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\about.blade.php ENDPATH**/ ?>