<?php $__env->startSection('title', 'FAQs'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">FAQs</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="space-y-6" x-data="{ showNew: false }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-display font-bold text-white">FAQs</h1>
            <p class="text-yamagata-silver text-sm mt-0.5"><?php echo e(number_format($faqs->count())); ?> questions</p>
        </div>
        <button @click="showNew = !showNew" class="btn-primary text-sm px-5 py-2.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New FAQ
        </button>
    </div>

    <!-- New FAQ Form -->
    <div x-show="showNew" x-transition x-cloak class="admin-card">
        <form action="<?php echo e(route('admin.content.faqs.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="admin-card-header">
                <h2>New FAQ</h2>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Question *</label>
                    <input type="text" name="question" required class="input-premium" placeholder="Enter question">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Answer *</label>
                    <textarea name="answer" required rows="3" class="input-premium" placeholder="Enter answer"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Category</label>
                    <input type="text" name="category" class="input-premium" placeholder="e.g. ordering, shipping, products">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="showNew = false" class="btn-secondary px-5 py-2.5">Cancel</button>
                    <button type="submit" class="btn-primary px-5 py-2.5">Save FAQ</button>
                </div>
            </div>
        </form>
    </div>

    <!-- FAQ List -->
    <div class="admin-card">
        <div class="overflow-x-auto">
            <?php if($faqs->count()): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="w-8">#</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-yamagata-steel text-xs"><?php echo e($faq->sort_order); ?></td>
                        <td>
                            <span class="text-white text-sm font-medium"><?php echo e($faq->question); ?></span>
                        </td>
                        <td class="text-sm max-w-[350px] truncate"><?php echo e($faq->answer); ?></td>
                        <td class="text-right">
                            <form action="<?php echo e(route('admin.content.faqs.destroy', $faq)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this FAQ?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="px-3 py-1.5 text-xs font-medium text-yamagata-silver hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="admin-empty">
                <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-yamagata-silver mb-1">No FAQs yet</p>
                <button @click="showNew = true" class="text-sm text-yamagata-red hover:text-yamagata-red-light transition-colors">Create your first FAQ →</button>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\content\faqs.blade.php ENDPATH**/ ?>