<?php $__env->startSection('title', 'Add Category'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-sm text-yamagata-silver hover:text-yamagata-red transition-colors inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Categories
            </a>
            <h1 class="text-2xl font-display font-bold text-white">Add Category</h1>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <?php if($errors->any()): ?>
        <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
            <ul class="text-sm text-red-400 space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>• <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Basic Info</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Name *</label>
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="input-premium" required placeholder="e.g. Katanas">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Slug</label>
                            <input type="text" name="slug" value="<?php echo e(old('slug')); ?>" class="input-premium" placeholder="auto-generated from name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Description</label>
                            <textarea name="description" class="input-premium" rows="3" placeholder="Brief description of this category..."><?php echo e(old('description')); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">SEO</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Meta Title</label>
                            <input type="text" name="meta_title" value="<?php echo e(old('meta_title')); ?>" class="input-premium" maxlength="255" placeholder="SEO title for this category">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Meta Description</label>
                            <textarea name="meta_description" class="input-premium" rows="2" maxlength="500" placeholder="SEO description..."><?php echo e(old('meta_description')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="admin-card">
                    <h2 class="text-lg font-semibold text-white mb-4">Organization</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Parent Category</label>
                            <select name="parent_id" class="input-premium">
                                <option value="">None (top-level)</option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id') == $parent->id ? 'selected' : ''); ?>><?php echo e($parent->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p class="text-xs text-yamagata-steel mt-1">Leave empty to create a top-level category.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-yamagata-mist mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="<?php echo e(old('sort_order', 0)); ?>" class="input-premium" min="0">
                            <p class="text-xs text-yamagata-steel mt-1">Lower numbers appear first.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full text-center py-3.5">
                    Create Category
                </button>

                <a href="<?php echo e(route('admin.categories.index')); ?>" class="block text-center text-sm text-yamagata-silver hover:text-white transition-colors py-2">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\categories\create.blade.php ENDPATH**/ ?>