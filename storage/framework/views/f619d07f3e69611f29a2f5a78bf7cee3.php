<?php $__env->startSection('admin-content'); ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Orders
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Order <?php echo e($order->reference_number); ?></h1>
        </div>
        <div class="flex gap-3">
            <form method="POST" action="<?php echo e(route('admin.orders.status', $order)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <select name="status" onchange="this.form.submit()" class="input-premium text-sm py-2">
                    <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="confirmed" <?php echo e($order->status === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                    <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>Processing</option>
                    <option value="delivered" <?php echo e($order->status === 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                    <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Timeline -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Status</h2>
                <div class="flex items-center gap-4">
                    <span class="admin-badge-<?php echo e($order->status); ?> text-sm px-4 py-2"><?php echo e($order->status_label); ?></span>
                    <span class="text-sm text-yamagata-silver">Updated <?php echo e($order->updated_at->diffForHumans()); ?></span>
                </div>
                <div class="grid grid-cols-4 gap-4 mt-6">
                    <?php $__currentLoopData = ['confirmed', 'processing', 'delivered', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center">
                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center <?php echo e($order->{$status . '_at'} ? 'bg-green-500/20 text-green-400' : 'bg-yamagata-charcoal text-yamagata-steel'); ?>">
                            <?php if($order->{$status . '_at'}): ?>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <?php else: ?>
                            <span class="text-xs">—</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-xs text-yamagata-silver mt-2 capitalize"><?php echo e($status); ?></p>
                        <?php if($order->{$status . '_at'}): ?>
                        <p class="text-xs text-yamagata-steel"><?php echo e($order->{$status . '_at'}->format('M d, H:i')); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Order Items -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Items</h2>
                <div class="space-y-4">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-4 p-4 bg-yamagata-charcoal/50 rounded-xl">
                        <?php if($item->product_image): ?>
                        <img src="<?php echo e(asset('storage/' . $item->product_image)); ?>" class="w-16 h-16 rounded-lg object-cover" alt="">
                        <?php endif; ?>
                        <div class="flex-1">
                            <p class="text-white font-medium"><?php echo e($item->product_name); ?></p>
                            <p class="text-sm text-yamagata-silver">Qty: <?php echo e($item->quantity); ?> �  $<?php echo e(number_format($item->unit_price, 0)); ?></p>
                            <?php if($item->variant): ?>
                            <p class="text-xs text-yamagata-steel">Variant: <?php echo e($item->variant); ?></p>
                            <?php endif; ?>
                        </div>
                        <span class="text-white font-semibold">$<?php echo e(number_format($item->total_price, 0)); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Notes -->
            <?php if($order->notes): ?>
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-2">Customer Notes</h2>
                <p class="text-yamagata-silver"><?php echo e($order->notes); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Summary -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-yamagata-silver">Subtotal</span>
                        <span class="text-white">$<?php echo e(number_format($order->subtotal, 0)); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-yamagata-silver">Shipping</span>
                        <span class="text-white"><?php echo e($order->shipping_cost > 0 ? '$' . number_format($order->shipping_cost, 0) : 'Free'); ?></span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-3 border-t border-yamagata-graphite/50">
                        <span class="text-white">Total</span>
                        <span class="text-yamagata-red">$<?php echo e(number_format($order->total, 0)); ?></span>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Customer</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-yamagata-silver">Name</p>
                        <p class="text-white"><?php echo e($order->customer_name); ?></p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Email</p>
                        <p class="text-white"><?php echo e($order->customer_email); ?></p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Phone</p>
                        <p class="text-white"><?php echo e($order->customer_phone); ?></p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Country</p>
                        <p class="text-white"><?php echo e($order->customer_country); ?></p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">City</p>
                        <p class="text-white"><?php echo e($order->customer_city); ?></p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">Address</p>
                        <p class="text-white"><?php echo e($order->customer_address); ?></p>
                    </div>
                </div>
            </div>

            <!-- Meta -->
            <div class="admin-card">
                <h2 class="text-lg font-semibold text-white mb-4">Details</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-yamagata-silver">Placed</p>
                        <p class="text-white"><?php echo e($order->created_at->format('M d, Y H:i')); ?></p>
                    </div>
                    <div>
                        <p class="text-yamagata-silver">IP Address</p>
                        <p class="text-white font-mono text-xs"><?php echo e($order->ip_address ?? '—'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>