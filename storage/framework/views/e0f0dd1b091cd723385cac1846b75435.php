<?php $__env->startSection('title', 'Customers'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Customers</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-display font-bold text-white">Customers</h1>
        <p class="text-yamagata-silver text-sm mt-0.5"><?php echo e(number_format($customers->total())); ?> customers</p>
    </div>

    <div class="admin-card">
        <div class="overflow-x-auto">
            <?php if($customers->count()): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                        <th>Loyalty</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <span class="text-white text-sm font-medium"><?php echo e($customer->name); ?></span>
                        </td>
                        <td class="text-sm"><?php echo e($customer->email); ?></td>
                        <td class="text-sm"><?php echo e($customer->orders_count ?? 0); ?></td>
                        <td class="text-sm text-white font-medium">$<?php echo e(number_format($customer->total_spent ?? 0, 0)); ?></td>
                        <td>
                            <?php $level = $customer->loyalty_level ?? 'none'; ?>
                            <span class="admin-badge admin-badge-<?php echo e($level); ?>"><?php echo e(ucfirst($level)); ?></span>
                        </td>
                        <td class="text-right">
                            <a href="<?php echo e(route('admin.customers.show', $customer)); ?>" class="px-3 py-1.5 text-xs font-medium text-yamagata-mist hover:text-white hover:bg-yamagata-charcoal rounded-lg transition-all">View</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                <p class="text-yamagata-silver">No customers yet</p>
            </div>
            <?php endif; ?>
        </div>
        <?php if($customers->hasPages()): ?>
        <div class="px-6 py-4 border-t border-yamagata-graphite/40">
            <?php echo e($customers->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\customers\index.blade.php ENDPATH**/ ?>