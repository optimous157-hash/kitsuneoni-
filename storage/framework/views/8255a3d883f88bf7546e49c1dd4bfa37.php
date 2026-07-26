<?php $__env->startSection('title', 'Page Sections'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Page Sections</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-display font-bold text-white">Page Sections</h1>
        <p class="text-yamagata-silver text-sm mt-0.5">Manage content for homepage and other pages</p>
    </div>

    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="admin-card">
            <form action="<?php echo e(route('admin.content.sections.update', $section->key)); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <div class="admin-card-header">
                    <h2 class="text-sm"><?php echo e(ucwords(str_replace('_', ' ', $section->key))); ?></h2>
                    <button type="submit" class="btn-primary text-xs px-4 py-2">Save</button>
                </div>
                <?php if(strlen($section->content) > 100): ?>
                    <textarea name="content" rows="4" class="input-premium"><?php echo e(old('content', $section->content)); ?></textarea>
                <?php else: ?>
                    <input type="text" name="content" value="<?php echo e(old('content', $section->content)); ?>" class="input-premium">
                <?php endif; ?>
            </form>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="admin-card">
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                <p class="text-yamagata-silver mb-1">No page sections found</p>
                <p class="text-xs text-yamagata-steel">Sections are created via the seeder.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\content\sections.blade.php ENDPATH**/ ?>