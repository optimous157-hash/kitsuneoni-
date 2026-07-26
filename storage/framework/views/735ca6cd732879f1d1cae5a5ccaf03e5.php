<?php $__env->startSection('title', 'Loyalty Program — Kitsuneoni'); ?>
<?php $__env->startSection('description', 'Join the Kitsuneoni loyalty program and unlock exclusive rewards, early access to new collections, and member-only pricing.'); ?>
<?php $__env->startSection('og_title', 'Loyalty Program — Kitsuneoni'); ?>
<?php $__env->startSection('og_description', 'Join the Kitsuneoni loyalty program and unlock exclusive rewards and member-only pricing.'); ?>

<?php $__env->startSection('content'); ?>


<section class="relative py-16 md:py-24 lg:py-32 bg-background overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-background via-primary/5 to-primary/[0.07]"></div>
    <div class="relative max-w-[1440px] mx-auto px-6 lg:px-12 text-center">
        <span class="text-8xl font-japanese text-primary/10 block mb-6">忠誠</span>
        <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Rewards</span>
        <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-4">Loyalty Program</h1>
        <p class="text-sm text-muted-foreground max-w-xl mx-auto leading-relaxed">The more you collect, the more you save. Join the Kitsuneoni family and unlock exclusive rewards.</p>
    </div>
</section>


<section class="py-16 md:py-24 lg:py-32 bg-background border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
            <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">How It Works</span>
            <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-6">Collect. Level Up. Save.</h2>
            <p class="text-sm text-muted-foreground max-w-lg mx-auto leading-relaxed">Every purchase earns you progress toward higher tiers. Your level is permanent — once achieved, it's yours forever.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <?php $__currentLoopData = [
                ['num' => '01', 'title' => 'Place Your Order', 'desc' => 'Browse the collection and complete your purchase. Every order counts toward your loyalty status.'],
                ['num' => '02', 'title' => 'Earn Rewards', 'desc' => 'After qualifying purchases, your discount tier activates automatically on your next order.'],
                ['num' => '03', 'title' => 'Level Up', 'desc' => 'Hit 3 purchases for Silver, 5 for Gold. Each tier unlocks deeper discounts across the entire catalog.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="text-center">
                <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block"><?php echo e($step['num']); ?></span>
                <h3 class="font-heading text-lg font-medium text-foreground mb-2"><?php echo e($step['title']); ?></h3>
                <p class="text-sm text-muted-foreground leading-relaxed"><?php echo e($step['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="py-16 md:py-24 lg:py-32 bg-card border-t border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
            <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Membership Tiers</span>
            <h2 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-6">Choose Your Tier</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            
            <div class="glass p-8 text-center group">
                <div class="w-20 h-20 mx-auto mb-6 bg-amber-900/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-700" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M12 6v12M8 14l4 4 4-4"/></svg>
                </div>
                <h3 class="font-heading text-xl font-medium text-foreground mb-1">Bronze</h3>
                <p class="text-xs text-muted-foreground mb-6">After 1 purchase</p>
                <div class="font-heading text-4xl font-light text-primary mb-2">3%</div>
                <p class="text-xs text-muted-foreground">Discount on next order</p>
            </div>

            
            <div class="glass p-8 text-center group border-primary/20">
                <div class="w-20 h-20 mx-auto mb-6 bg-muted flex items-center justify-center">
                    <svg class="w-8 h-8 text-muted-foreground" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M12 6v12M8 14l4 4 4-4"/></svg>
                </div>
                <h3 class="font-heading text-xl font-medium text-foreground mb-1">Silver</h3>
                <p class="text-xs text-muted-foreground mb-6">After 3 purchases</p>
                <div class="font-heading text-4xl font-light text-primary mb-2">5%</div>
                <p class="text-xs text-muted-foreground">Discount on all future orders</p>
            </div>

            
            <div class="glass p-8 text-center group border-primary/30">
                <div class="w-20 h-20 mx-auto mb-6 bg-primary/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M12 6v12M8 14l4 4 4-4"/></svg>
                </div>
                <h3 class="font-heading text-xl font-medium text-foreground mb-1">Gold</h3>
                <p class="text-xs text-muted-foreground mb-6">After 5 purchases</p>
                <div class="font-heading text-4xl font-light text-primary mb-2">10%</div>
                <p class="text-xs text-muted-foreground">Discount on entire catalog</p>
            </div>
        </div>

        <div class="text-center mt-16">
            <p class="text-sm text-muted-foreground mb-8">Your loyalty level is permanent. Once achieved, it's yours forever.</p>
            <a href="<?php echo e(route('shop.index')); ?>" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                Start Collecting
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\loyalty.blade.php ENDPATH**/ ?>