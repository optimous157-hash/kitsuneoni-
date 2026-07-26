<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Products</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Products</h1>
            <p class="text-yamagata-silver text-sm mt-1"><?php echo e(number_format($products->total())); ?> products</p>
        </div>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-primary text-sm px-5 py-2.5">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card">
        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="flex flex-wrap gap-3">
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search products..." class="input-premium text-sm py-2 max-w-xs">
            <select name="category_id" class="input-premium text-sm py-2 max-w-xs">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="btn-primary text-sm px-4 py-2">Filter</button>
        </form>
    </div>

    <!-- Products Table -->
    <div class="admin-card overflow-x-auto">
        <?php if($products->count()): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <img src="<?php echo e($product->primary_image_url); ?>" class="w-12 h-12 rounded-lg object-cover" alt="">
                    </td>
                    <td>
                        <div>
                            <p class="text-white text-sm font-medium"><?php echo e($product->name); ?></p>
                            <div class="flex gap-2 mt-1">
                                <?php if($product->is_featured): ?>
                                <span class="text-xs text-yamagata-gold">Featured</span>
                                <?php endif; ?>
                                <?php if($product->is_new): ?>
                                <span class="text-xs text-yamagata-red">New</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="text-yamagata-silver font-mono text-xs"><?php echo e($product->sku ?? '—'); ?></td>
                    <td class="text-sm"><?php echo e($product->category->name ?? '—'); ?></td>
                    <td class="text-white font-semibold text-sm">$<?php echo e(number_format($product->price, 0)); ?></td>
                    <td>
                        <span class="text-sm <?php echo e($product->stock > 0 ? 'text-green-400' : 'text-red-400'); ?>">
                            <?php echo e($product->stock); ?>

                        </span>
                    </td>
                    <td>
                        <span class="admin-badge <?php echo e($product->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400'); ?>">
                            <?php echo e($product->is_active ? 'Active' : 'Draft'); ?>

                        </span>
                    </td>
                    <td>
                        <div class="flex gap-3">
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-sm text-yamagata-red hover:text-yamagata-red-light">Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" onsubmit="return confirm('Delete this product?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-sm text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="mt-6"><?php echo e($products->links()); ?></div>
        <?php else: ?>
        <p class="text-yamagata-silver text-center py-12">No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\products\index.blade.php ENDPATH**/ ?>