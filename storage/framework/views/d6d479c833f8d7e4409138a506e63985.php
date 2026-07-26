<?php $__env->startSection('title', $category->meta_title ?: $category->name . ' — Kitsuneoni'); ?>
<?php $__env->startSection('description', $category->meta_description ?: $category->description); ?>
<?php $__env->startSection('og_title', $category->meta_title ?: $category->name); ?>
<?php $__env->startSection('og_description', $category->meta_description ?: $category->description); ?>
<?php $__env->startSection('page_json_ld'); ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "<?php echo e($category->name); ?> — Kitsuneoni",
    "description": "<?php echo e($category->meta_description ?: $category->description); ?>",
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
        { "@type": "ListItem", "position": 2, "name": "Shop", "item": "<?php echo e(route('shop.index')); ?>" },
        { "@type": "ListItem", "position": 3, "name": "<?php echo e($category->name); ?>", "item": "<?php echo e(url()->current()); ?>" }
    ]
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="border-b border-border">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-8">
        <nav class="flex items-center gap-2 text-xs text-muted-foreground mb-4 overflow-x-auto">
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($bc['url']): ?>
                <a href="<?php echo e($bc['url']); ?>" class="hover:text-foreground transition-colors whitespace-nowrap"><?php echo e($bc['label']); ?></a>
                <span class="text-muted-foreground/40">/</span>
                <?php else: ?>
                <span class="text-foreground font-medium whitespace-nowrap"><?php echo e($bc['label']); ?></span>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
        <h1 class="font-heading text-3xl md:text-4xl font-light text-foreground"><?php echo e($category->name); ?></h1>
        <?php if($category->description): ?>
        <p class="text-muted-foreground text-sm mt-2"><?php echo e($category->description); ?></p>
        <?php endif; ?>
    </div>
</div>

<section class="py-12">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <?php if($products->count()): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('shop.partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="mt-8">
            <?php echo e($products->withQueryString()->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-20">
            <p class="text-muted-foreground text-lg">No products found in this category.</p>
            <a href="<?php echo e(route('shop.index')); ?>" class="mt-6 inline-flex items-center gap-2 bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">Browse All Products</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\category.blade.php ENDPATH**/ ?>