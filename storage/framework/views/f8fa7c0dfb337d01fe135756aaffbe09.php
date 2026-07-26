<?php $__env->startSection('title', 'Order — Kitsuneoni'); ?>
<?php $__env->startSection('description', 'Place your order for handcrafted Kitsuneoni blades. No payment required upfront — we confirm via email within 24 hours.'); ?>
<?php $__env->startSection('og_title', 'Order — Kitsuneoni'); ?>
<?php $__env->startSection('og_description', 'Place your order for handcrafted Kitsuneoni blades. No payment required upfront.'); ?>

<?php $__env->startSection('content'); ?>

<section class="py-16 md:py-24 lg:py-32">
    <div class="max-w-2xl mx-auto px-6 lg:px-12">

        <div class="text-center mb-12">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Place Your Order</p>
            <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-4">Order Now</h1>
            <p class="text-sm text-muted-foreground max-w-md mx-auto leading-relaxed">Fill in the form below and we'll confirm your order via email within 24 hours. No payment required upfront.</p>
        </div>

        <?php if($errors->any()): ?>
        <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
            <p class="text-sm text-red-600 dark:text-red-400 font-medium">Please fix the errors below.</p>
        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('order.store')); ?>" method="POST" x-data="{ loading: false }" @submit="loading = true" class="space-y-6">
            <?php echo csrf_field(); ?>

            
            <?php if($product): ?>
            <div class="bg-card border border-border p-6 rounded-2xl">
                <div class="flex items-start gap-4">
                    <img src="<?php echo e($product->primary_image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-20 h-20 rounded-xl object-cover shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] text-primary font-semibold tracking-wider uppercase mb-1"><?php echo e($product->category->name ?? 'Collection'); ?></p>
                        <h3 class="text-lg font-medium text-foreground"><?php echo e($product->name); ?></h3>
                        <p class="text-xl font-bold text-foreground mt-1"><?php echo e($product->formatted_price); ?></p>
                    </div>
                </div>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <div class="mt-4 pt-4 border-t border-border">
                    <label class="block text-sm font-medium text-foreground mb-2">Quantity</label>
                    <div class="flex items-center gap-1 w-fit">
                        <button type="button" @click="$refs.qty.value = Math.max(1, parseInt($refs.qty.value) - 1); $dispatch('change')" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">−</button>
                        <input type="number" name="quantity" x-ref="qty" value="<?php echo e(old('quantity', 1)); ?>" min="1" max="10" readonly class="w-16 h-10 text-center bg-transparent border-none text-lg font-bold text-foreground focus:outline-none">
                        <button type="button" @click="$refs.qty.value = Math.min(10, parseInt($refs.qty.value) + 1); $dispatch('change')" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">+</button>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="bg-card border border-border p-6 rounded-2xl">
                <h3 class="text-sm font-medium text-foreground mb-3">Select Product <span class="text-primary">*</span></h3>
                <select name="product_id" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground focus:outline-none focus:border-primary transition-colors text-sm" required>
                    <option value="">Choose a product...</option>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>" <?php echo e(request('product_id') == $p->id ? 'selected' : ''); ?>>
                        <?php echo e($p->name); ?> — <?php echo e($p->formatted_price); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="mt-4 pt-4 border-t border-border">
                    <label class="block text-sm font-medium text-foreground mb-2">Quantity</label>
                    <div class="flex items-center gap-1 w-fit">
                        <button type="button" @click="$refs.qty2.value = Math.max(1, parseInt($refs.qty2.value) - 1)" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">−</button>
                        <input type="number" name="quantity" x-ref="qty2" value="<?php echo e(old('quantity', 1)); ?>" min="1" max="10" readonly class="w-16 h-10 text-center bg-transparent border-none text-lg font-bold text-foreground focus:outline-none">
                        <button type="button" @click="$refs.qty2.value = Math.min(10, parseInt($refs.qty2.value) + 1)" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">+</button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            
            <div class="bg-card border border-border p-6 rounded-2xl space-y-5">
                <h3 class="text-sm font-medium text-foreground mb-1">Your Information</h3>
                <p class="text-xs text-muted-foreground mb-4">We'll use this to confirm your order and send you updates.</p>

                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Full Name <span class="text-primary">*</span></label>
                    <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="e.g. John Smith">
                    <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Email <span class="text-primary">*</span></label>
                        <input type="email" name="customer_email" value="<?php echo e(old('customer_email')); ?>" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="your@email.com">
                        <?php $__errorArgs = ['customer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Phone <span class="text-primary">*</span></label>
                        <input type="text" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="+1 (555) 000-0000">
                        <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="bg-card border border-border p-6 rounded-2xl space-y-5">
                <h3 class="text-sm font-medium text-foreground mb-1">Shipping Details</h3>
                <p class="text-xs text-muted-foreground mb-4">Where should we send your order?</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Country <span class="text-primary">*</span></label>
                        <div
                            x-data="countrySelect({
                                name: 'customer_country',
                                old: <?php echo e(Js::from(old('customer_country'))); ?>,
                                countries: <?php echo e(Js::from(config('countries'))); ?>

                            })"
                            x-init="init()"
                            class="relative"
                        >
                            <input type="hidden" name="customer_country" :value="selected">
                            <button type="button" @click="open = !open; if(open) $nextTick(() => $refs.search.focus())" @click.outside="open = false"
                                class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-left text-foreground focus:outline-none focus:border-primary transition-colors text-sm flex items-center justify-between">
                                <span x-text="selected || 'Select country...'" :class="selected ? 'text-foreground' : 'text-muted-foreground/50'"></span>
                                <svg class="w-4 h-4 text-muted-foreground shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="absolute z-20 mt-1 w-full bg-card border border-border rounded-xl shadow-lg max-h-60 overflow-y-auto">
                                <div class="p-2 sticky top-0 bg-card border-b border-border">
                                    <input type="text" x-model="query" x-ref="search" placeholder="Search country..."
                                        class="w-full px-3 py-2 bg-muted border border-border rounded-lg text-foreground focus:outline-none focus:border-primary text-sm">
                                </div>
                                <template x-for="c in filtered" :key="c">
                                    <button type="button" @click="select(c)"
                                        class="w-full text-left px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors"
                                        :class="c === selected ? 'bg-primary/10 text-primary' : ''"
                                        x-text="c"></button>
                                </template>
                                <div x-show="filtered.length === 0" class="px-4 py-3 text-sm text-muted-foreground">No matches</div>
                            </div>
                        </div>
                        <?php $__errorArgs = ['customer_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">City <span class="text-primary">*</span></label>
                        <input type="text" name="customer_city" value="<?php echo e(old('customer_city')); ?>"
                            class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="e.g. Tokyo">
                        <?php $__errorArgs = ['customer_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Full Address <span class="text-primary">*</span></label>
                    <textarea name="customer_address" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm resize-none" rows="3" required placeholder="Street address, apartment number, postal code..."><?php echo e(old('customer_address')); ?></textarea>
                    <?php $__errorArgs = ['customer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Order Notes <span class="text-muted-foreground font-normal">(Optional)</span></label>
                    <textarea name="notes" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm resize-none" rows="2" placeholder="Special requests, gift message..."><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            
            <div class="bg-card border border-border p-6 rounded-2xl">
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-foreground">How it works</p>
                        <p class="text-xs text-muted-foreground mt-0.5">After submitting, we'll confirm your order via email within 24 hours with payment details.</p>
                    </div>
                </div>

                <button type="submit" :disabled="loading" class="w-full bg-[#c41e3a] hover:bg-[#9b1830] text-white font-semibold text-base py-4 px-8 rounded-xl transition-all duration-300 shadow-[0_0_30px_rgba(196,30,58,0.25)] hover:shadow-[0_0_50px_rgba(196,30,58,0.4)] hover:scale-[1.01] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <span x-show="!loading">Submit Order Request</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Processing...
                    </span>
                </button>
                <p class="text-xs text-muted-foreground text-center mt-3">No payment required now. We'll reach out to confirm.</p>
            </div>

            
            <div class="grid grid-cols-3 gap-4">
                <?php $__currentLoopData = [
                    ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'label' => 'Email confirmation'],
                    ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Gift case included'],
                    ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Worldwide shipping'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-center">
                    <div class="w-8 h-8 mx-auto mb-2 rounded-lg bg-primary/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo e($trust['icon']); ?>"/></svg>
                    </div>
                    <p class="text-[11px] text-muted-foreground leading-tight"><?php echo e($trust['label']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </form>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\order.blade.php ENDPATH**/ ?>