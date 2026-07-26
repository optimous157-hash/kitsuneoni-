<?php $__env->startSection('title', 'Contact — Kitsuneoni'); ?>
<?php $__env->startSection('description', 'Get in touch with Kitsuneoni via Telegram or email. We typically respond within 24 hours.'); ?>
<?php $__env->startSection('og_title', 'Contact Kitsuneoni'); ?>
<?php $__env->startSection('og_description', 'Get in touch with Kitsuneoni via Telegram or email.'); ?>
<?php $__env->startSection('page_json_ld'); ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact Kitsuneoni",
    "url": "<?php echo e(url()->current()); ?>",
    "description": "Get in touch with Kitsuneoni via Telegram or email."
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-28 pb-20 min-h-screen bg-background">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="max-w-3xl mx-auto text-center mb-16">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Get in Touch</p>
            <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-4">Contact Us</h1>
            <p class="text-muted-foreground leading-relaxed">We're here to help. Reach out through any of these channels and we'll respond within 24 hours.</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-6 max-w-3xl mx-auto">
            <a href="<?php echo e(config('site.contact.telegram')); ?>" target="_blank" class="group border border-border bg-card rounded-xl p-8 text-center hover:border-primary/50 transition-all duration-300">
                <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-500/20 transition-colors">
                    <svg class="w-7 h-7 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                </div>
                <h3 class="font-heading text-xl font-medium text-foreground mb-1">Telegram</h3>
                <p class="text-sm text-muted-foreground">@katana_oni</p>
            </a>

            <a href="mailto:<?php echo e(config('site.contact.email')); ?>" class="group border border-border bg-card rounded-xl p-8 text-center hover:border-primary/50 transition-all duration-300">
                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary/20 transition-colors">
                    <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-heading text-xl font-medium text-foreground mb-1">Email</h3>
                <p class="text-sm text-muted-foreground"><?php echo e(config('site.contact.email')); ?></p>
            </a>
        </div>

        
        <div class="max-w-2xl mx-auto mt-20">
            <div class="border border-border bg-card rounded-xl p-8 md:p-12">
                <h2 class="font-heading text-2xl font-light text-foreground mb-2">Send us a message</h2>
                <p class="text-sm text-muted-foreground mb-8">Prefer email? Fill out the form below and we'll get back to you.</p>

                <form action="<?php echo e(route('contact.send')); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] tracking-[0.2em] uppercase text-muted-foreground mb-2">Name</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary/50 transition-all">
                        </div>
                        <div>
                            <label class="block text-[11px] tracking-[0.2em] uppercase text-muted-foreground mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary/50 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] tracking-[0.2em] uppercase text-muted-foreground mb-2">Subject</label>
                        <input type="text" name="subject" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] tracking-[0.2em] uppercase text-muted-foreground mb-2">Message</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary/50 transition-all resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 bg-primary text-primary-foreground text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl hover:opacity-90 transition-all duration-300 flex items-center justify-center gap-2">
                        Send Message
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views/shop/contact.blade.php ENDPATH**/ ?>