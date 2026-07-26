<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-content'); ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Dashboard</h1>
            <p class="text-yamagata-silver text-sm mt-0.5">Welcome back, <?php echo e(auth()->user()->name); ?></p>
        </div>
        <div class="flex items-center gap-2 text-xs text-yamagata-steel">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <?php echo e(now()->format('l, F j, Y')); ?>

        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="admin-stat group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-yamagata-silver uppercase tracking-wide">Total Orders</p>
                    <p class="text-2xl font-bold text-white mt-1.5"><?php echo e(number_format($stats['total_orders'])); ?></p>
                </div>
                <div class="w-10 h-10 bg-yamagata-red/10 rounded-xl flex items-center justify-center group-hover:bg-yamagata-red/15 transition-colors">
                    <svg class="w-5 h-5 text-yamagata-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <?php if($stats['pending_orders'] > 0): ?>
            <div class="flex items-center gap-1 mt-2.5">
                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span>
                <span class="text-xs text-yellow-400"><?php echo e($stats['pending_orders']); ?> pending</span>
            </div>
            <?php endif; ?>
        </a>

        <div class="admin-stat">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-yamagata-silver uppercase tracking-wide">Revenue</p>
                    <p class="text-2xl font-bold text-white mt-1.5">$<?php echo e(number_format($stats['total_revenue'], 0)); ?></p>
                </div>
                <div class="w-10 h-10 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <a href="<?php echo e(route('admin.products.index')); ?>" class="admin-stat group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-yamagata-silver uppercase tracking-wide">Products</p>
                    <p class="text-2xl font-bold text-white mt-1.5"><?php echo e(number_format($stats['total_products'])); ?></p>
                </div>
                <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center group-hover:bg-purple-500/15 transition-colors">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('admin.newsletter.index')); ?>" class="admin-stat group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-yamagata-silver uppercase tracking-wide">Subscribers</p>
                    <p class="text-2xl font-bold text-white mt-1.5"><?php echo e(number_format($stats['newsletter_subscribers'])); ?></p>
                </div>
                <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:bg-blue-500/15 transition-colors">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Order Status -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Order Status</h2>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-xs text-yamagata-red hover:text-yamagata-red-light transition-colors">View all →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            <?php $__currentLoopData = ['pending' => 'yellow', 'confirmed' => 'blue', 'processing' => 'purple', 'delivered' => 'green', 'cancelled' => 'red']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.orders.index', ['status' => $status])); ?>" class="relative p-4 rounded-xl bg-yamagata-charcoal/30 border border-yamagata-graphite/30 hover:border-<?php echo e($color); ?>-500/30 transition-all text-center group">
                <p class="text-2xl font-bold text-white"><?php echo e($ordersByStatus[$status] ?? 0); ?></p>
                <p class="text-xs text-yamagata-silver mt-1 capitalize"><?php echo e($status); ?></p>
                <span class="absolute top-3 right-3 w-2 h-2 bg-<?php echo e($color); ?>-400 rounded-full opacity-60"></span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 admin-card">
            <div class="admin-card-header">
                <h2>Recent Orders</h2>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-xs text-yamagata-red hover:text-yamagata-red-light transition-colors">View all →</a>
            </div>

            <?php if($recentOrders->count()): ?>
            <div class="overflow-x-auto -mx-1.5">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th class="text-right">Total</th>
                            <th>Status</th>
                            <th class="text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="text-yamagata-red hover:text-yamagata-red-light font-mono text-xs font-medium">
                                    <?php echo e($order->reference_number); ?>

                                </a>
                            </td>
                            <td>
                                <p class="text-white text-sm"><?php echo e($order->customer_name); ?></p>
                                <p class="text-xs text-yamagata-steel"><?php echo e($order->customer_email); ?></p>
                            </td>
                            <td class="text-right">
                                <span class="text-white font-semibold text-sm">$<?php echo e(number_format($order->total, 0)); ?></span>
                            </td>
                            <td>
                                <span class="admin-badge admin-badge-<?php echo e($order->status); ?>"><?php echo e($order->status_label); ?></span>
                            </td>
                            <td class="text-right text-yamagata-silver text-xs"><?php echo e($order->created_at->format('M d, H:i')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-yamagata-silver">No orders yet</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-6">
            <!-- Top Products -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2>Top Products</h2>
                </div>
                <?php if($topProducts->count()): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-yamagata-charcoal/30 transition-colors">
                        <span class="text-xs font-bold text-yamagata-steel w-4 text-center"><?php echo e($index + 1); ?></span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-white truncate"><?php echo e($product->name); ?></p>
                            <p class="text-[11px] text-yamagata-steel"><?php echo e($product->category->name ?? 'Uncategorized'); ?></p>
                        </div>
                        <span class="text-xs text-yamagata-silver font-medium"><?php echo e($product->sales_count); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <p class="text-sm text-yamagata-steel text-center py-4">No sales data yet</p>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2>Quick Actions</h2>
                </div>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.products.create')); ?>" class="flex items-center gap-3 p-3 rounded-xl bg-yamagata-red/5 border border-yamagata-red/10 hover:border-yamagata-red/25 hover:bg-yamagata-red/10 transition-all group">
                        <div class="w-8 h-8 bg-yamagata-red/10 rounded-lg flex items-center justify-center group-hover:bg-yamagata-red/20 transition-colors">
                            <svg class="w-4 h-4 text-yamagata-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Add Product</p>
                            <p class="text-[11px] text-yamagata-steel">Create a new listing</p>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>" class="flex items-center gap-3 p-3 rounded-xl bg-yamagata-charcoal/30 border border-yamagata-graphite/30 hover:border-yamagata-graphite/50 transition-all group">
                        <div class="w-8 h-8 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Pending Orders</p>
                            <p class="text-[11px] text-yamagata-steel">Review & confirm</p>
                        </div>
                    </a>
                    <a href="<?php echo e(route('admin.orders.export')); ?>" class="flex items-center gap-3 p-3 rounded-xl bg-yamagata-charcoal/30 border border-yamagata-graphite/30 hover:border-yamagata-graphite/50 transition-all group">
                        <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Export Orders</p>
                            <p class="text-[11px] text-yamagata-steel">Download CSV</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>