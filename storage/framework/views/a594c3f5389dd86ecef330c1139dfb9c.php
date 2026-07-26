<?php $__env->startSection('title', 'Newsletter'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Newsletter</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Newsletter</h1>
            <p class="text-yamagata-silver text-sm mt-0.5"><?php echo e(number_format($subscribers->total())); ?> subscribers</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            <?php if($subscribers->count()): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <span class="text-white text-sm font-medium"><?php echo e($sub->email); ?></span>
                        </td>
                        <td class="text-sm"><?php echo e($sub->created_at->format('M d, Y')); ?></td>
                        <td>
                            <span class="admin-badge <?php echo e($sub->is_active ? 'admin-badge-active' : 'admin-badge-draft'); ?>">
                                <?php echo e($sub->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td class="text-right">
                            <form action="<?php echo e(route('admin.newsletter.destroy', $sub)); ?>" method="POST" class="inline" onsubmit="return confirm('Remove this subscriber?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="px-3 py-1.5 text-xs font-medium text-yamagata-silver hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <p class="text-yamagata-silver">No subscribers yet</p>
            </div>
            <?php endif; ?>
        </div>
        <?php if($subscribers->hasPages()): ?>
        <div class="px-6 py-4 border-t border-yamagata-graphite/40">
            <?php echo e($subscribers->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\newsletter\index.blade.php ENDPATH**/ ?>