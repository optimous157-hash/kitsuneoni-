<?php $__env->startSection('title', 'Contact Messages — Kitsuneoni Admin'); ?>

<?php $__env->startSection('admin-content'); ?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">Contact Messages</h1>
            <p class="text-sm text-yamagata-silver mt-1"><?php echo e($submissions->total()); ?> total messages</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="flex items-center gap-2 mb-4">
            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="px-3 py-1.5 text-xs font-medium rounded-lg <?php echo e(!request('status') ? 'bg-yamagata-red/20 text-yamagata-red' : 'text-yamagata-silver hover:text-white bg-yamagata-charcoal'); ?> transition-all">All</a>
            <a href="<?php echo e(route('admin.contacts.index', ['status' => 'unread'])); ?>" class="px-3 py-1.5 text-xs font-medium rounded-lg <?php echo e(request('status') === 'unread' ? 'bg-yamagata-red/20 text-yamagata-red' : 'text-yamagata-silver hover:text-white bg-yamagata-charcoal'); ?> transition-all">
                Unread
                <?php if($unreadCount > 0): ?>
                <span class="ml-1 px-1.5 py-0.5 bg-yamagata-red/30 text-yamagata-red text-[10px] rounded-full"><?php echo e($unreadCount); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.contacts.index', ['status' => 'read'])); ?>" class="px-3 py-1.5 text-xs font-medium rounded-lg <?php echo e(request('status') === 'read' ? 'bg-yamagata-red/20 text-yamagata-red' : 'text-yamagata-silver hover:text-white bg-yamagata-charcoal'); ?> transition-all">Read</a>
        </div>

        <?php if($submissions->count()): ?>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e($submission->status === 'unread' ? 'bg-yamagata-red/5' : ''); ?>">
                        <td class="font-medium text-white"><?php echo e($submission->name); ?></td>
                        <td><a href="mailto:<?php echo e($submission->email); ?>" class="text-yamagata-red hover:underline"><?php echo e($submission->email); ?></a></td>
                        <td><?php echo e($submission->subject ?: '(no subject)'); ?></td>
                        <td class="text-yamagata-silver text-xs"><?php echo e($submission->created_at->format('M j, Y g:i A')); ?></td>
                        <td>
                            <?php if($submission->status === 'unread'): ?>
                            <span class="admin-badge admin-badge-pending">Unread</span>
                            <?php else: ?>
                            <span class="admin-badge admin-badge-delivered">Read</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.contacts.show', $submission)); ?>" class="btn-secondary text-xs py-1.5 px-3">View</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <?php echo e($submissions->links()); ?>

        </div>
        <?php else: ?>
        <div class="admin-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p>No messages found.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\contacts\index.blade.php ENDPATH**/ ?>