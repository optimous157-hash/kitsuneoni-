<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<a href="<?php echo e(route('admin.dashboard')); ?>" class="text-yamagata-silver hover:text-white transition-colors">Dashboard</a>
<span class="text-yamagata-steel">/</span>
<span class="text-white">Settings</span>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-display font-bold text-white">Settings</h1>
        <p class="text-yamagata-silver text-sm mt-0.5">Manage your store configuration</p>
    </div>

    <?php if($errors->any()): ?>
    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl mb-6">
        <ul class="text-sm text-red-400 space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>• <?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2>General</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Site Name</label>
                    <input type="text" name="settings[site_name]" value="<?php echo e(old('settings.site_name', $settings['site_name'] ?? 'Kitsuneoni')); ?>" class="input-premium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Tagline</label>
                    <input type="text" name="settings[site_tagline]" value="<?php echo e(old('settings.site_tagline', $settings['site_tagline'] ?? '')); ?>" class="input-premium">
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2>Contact</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Email</label>
                    <input type="email" name="settings[contact_email]" value="<?php echo e(old('settings.contact_email', $settings['contact_email'] ?? '')); ?>" class="input-premium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Phone</label>
                    <input type="text" name="settings[contact_phone]" value="<?php echo e(old('settings.contact_phone', $settings['contact_phone'] ?? '')); ?>" class="input-premium">
                </div>

            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h2>SEO</h2>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Meta Title</label>
                    <input type="text" name="settings[meta_title]" value="<?php echo e(old('settings.meta_title', $settings['meta_title'] ?? '')); ?>" class="input-premium" maxlength="255">
                </div>
                <div>
                    <label class="block text-sm font-medium text-yamagata-mist mb-1.5">Meta Description</label>
                    <textarea name="settings[meta_description]" rows="3" class="input-premium" maxlength="500"><?php echo e(old('settings.meta_description', $settings['meta_description'] ?? '')); ?></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary px-8 py-3">
                Save Settings
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\settings\index.blade.php ENDPATH**/ ?>