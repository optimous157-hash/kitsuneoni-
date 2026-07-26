<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — Kitsuneoni</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/apple-touch-icon.png')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Noto+Serif+JP:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: {
                fontFamily: { sans: ['Inter','ui-sans-serif','system-ui','sans-serif'], display: ['"Playfair Display"','serif'], japanese: ['"Noto Serif JP"','serif'] },
                colors: { yamagata: { black:'#0a0a0a',dark:'#111111',charcoal:'#1a1a1a',graphite:'#2a2a2a',steel:'#3a3a3a',silver:'#8a8a8a',mist:'#b5b5b5',pearl:'#e5e5e5',snow:'#f5f5f5',white:'#fafafa',red:'#c41e3a','red-dark':'#9b1830','red-light':'#e63950',gold:'#c9a84c','gold-dark':'#b8933d' } },
            }}
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .login-input { width:100%; padding:0.75rem 1rem; background:rgba(26,26,26,0.6); border:1px solid rgba(42,42,42,0.6); border-radius:0.75rem; color:#fafafa; font-size:0.875rem; outline:none; transition:all 0.2s; }
        .login-input::placeholder { color:#3a3a3a; }
        .login-input:focus { border-color:rgba(196,30,58,0.4); box-shadow:0 0 0 3px rgba(196,30,58,0.08); }
    </style>
</head>
<body class="bg-[#080808] min-h-screen flex items-center justify-center px-4 font-sans relative overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] opacity-15" style="background: radial-gradient(ellipse at center top, rgba(196,30,58,0.3) 0%, transparent 70%);"></div>
    </div>

    <div class="w-full max-w-sm relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center justify-center mb-8" aria-label="Kitsuneoni — Home">
                <img src="<?php echo e(asset('storage/brand/logo.png')); ?>" srcset="<?php echo e(asset('storage/brand/logo@2x.png')); ?> 2x"
                     width="512" height="512" alt="Kitsuneoni" class="w-auto object-contain"
                     style="height:64px;filter: drop-shadow(0 0 8px rgba(201,168,76,0.3)) drop-shadow(0 1px 2px rgba(0,0,0,0.4));">
            </a>
            <h1 class="text-xl font-display font-bold text-white">Kitsuneoni Admin</h1>
            <p class="text-yamagata-steel text-sm mt-1.5">Sign in to manage your store</p>
        </div>

        <!-- Form -->
        <div class="bg-yamagata-dark/60 backdrop-blur-xl border border-yamagata-graphite/40 rounded-2xl p-7">
            <?php if(session('errors')): ?>
            <div class="mb-5 p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php echo e(session('errors')->first()); ?>

            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-[13px] font-medium text-yamagata-silver mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus class="login-input" placeholder="admin@yamagataoni.com">
                </div>

                <div>
                    <label class="block text-[13px] font-medium text-yamagata-silver mb-2">Password</label>
                    <input type="password" name="password" required class="login-input" placeholder="••••••••">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-yamagata-graphite bg-yamagata-charcoal text-yamagata-red focus:ring-yamagata-red/30 cursor-pointer">
                    <label for="remember" class="text-sm text-yamagata-silver cursor-pointer">Remember me</label>
                </div>

                <button type="submit" class="w-full py-3 bg-yamagata-red text-white text-sm font-medium rounded-xl hover:bg-yamagata-red-dark transition-all duration-200 shadow-lg shadow-yamagata-red/15">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-yamagata-steel mt-6">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-yamagata-silver transition-colors">← Back to store</a>
        </p>
    </div>
</body>
</html>
<?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\admin\login.blade.php ENDPATH**/ ?>