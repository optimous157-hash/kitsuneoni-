<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo e(url('/')); ?></loc>
        <priority>1.0</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc><?php echo e(route('shop.index')); ?></loc>
        <priority>0.9</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc><?php echo e(route('about')); ?></loc>
        <priority>0.7</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo e(route('contact')); ?></loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo e(route('faq')); ?></loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo e(route('loyalty')); ?></loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc><?php echo e(route('order.create')); ?></loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
    </url>
<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e(route('shop.category', $category->slug)); ?></loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        <lastmod><?php echo e($category->updated_at->toW3cString()); ?></lastmod>
    </url>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <url>
        <loc><?php echo e(route('shop.product', $product->slug)); ?></loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        <lastmod><?php echo e($product->updated_at->toW3cString()); ?></lastmod>
    </url>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>
<?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\sitemap.blade.php ENDPATH**/ ?>