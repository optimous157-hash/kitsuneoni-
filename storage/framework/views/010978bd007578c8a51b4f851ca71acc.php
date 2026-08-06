<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark" x-data x-init="$store.theme.init()" :class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#0A0A0B">

    <!-- Favicons / PWA icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('images/favicon-16x16.png')); ?>">
    <link rel="icon" type="image/png" sizes="48x48" href="<?php echo e(asset('images/favicon-48x48.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/apple-touch-icon.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">
    <meta name="apple-mobile-web-app-title" content="Kitsuneoni">

    <title><?php echo $__env->yieldContent('title', config('site.seo.title')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', config('site.seo.description')); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', config('site.seo.keywords')); ?>">
    <meta name="robots" content="<?php echo $__env->yieldContent('robots', 'index, follow'); ?>">
    <link rel="canonical" href="<?php echo $__env->yieldContent('canonical', url()->current()); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $__env->yieldContent('canonical', url()->current()); ?>">
    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', config('site.seo.title')); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', config('site.seo.description')); ?>">
    <meta property="og:image" content="<?php echo $__env->yieldContent('og_image', config('site.seo.og_image')); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo $__env->yieldContent('og_image_alt', config('site.seo.title')); ?>">
    <meta property="og:site_name" content="Kitsuneoni">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@katana_oni">
    <meta name="twitter:creator" content="@katana_oni">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('og_title', config('site.seo.title')); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('og_description', config('site.seo.description')); ?>">
    <meta name="twitter:image" content="<?php echo $__env->yieldContent('og_image', config('site.seo.og_image')); ?>">

    <style>[x-cloak] { display: none !important; }</style>

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Kitsuneoni",
        "url": "<?php echo e(url('/')); ?>",
        "logo": "<?php echo e(asset('storage/brand/logo@2x.png')); ?>",
        "image": "<?php echo e(asset('storage/brand/logo@2x.png')); ?>",
        "description": "<?php echo e(config('site.seo.description')); ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "email": "<?php echo e(config('site.contact.email')); ?>",
            "contactType": "customer service"
        }
    }
    </script>
    <?php echo $__env->yieldContent('page_json_ld'); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        heading: ['"Cormorant Garamond"', 'serif'],
                        display: ['"Cormorant Garamond"', 'serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                        japanese: ['"Noto Serif JP"', 'serif'],
                    },
                    colors: {
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        card: 'hsl(var(--card))',
                        primary: 'hsl(var(--primary))',
                        'primary-foreground': 'hsl(var(--primary-foreground))',
                        muted: 'hsl(var(--muted))',
                        'muted-foreground': 'hsl(var(--muted-foreground))',
                        border: 'hsl(var(--border))',
                        accent: 'hsl(var(--accent))',
                        destructive: 'hsl(var(--destructive))',
                        yamagata: {
                            black: '#0a0a0b',
                            dark: '#111111',
                            charcoal: '#1a1a1a',
                            graphite: '#2a2a2a',
                            steel: '#3a3a3a',
                            silver: '#8a8a8a',
                            mist: '#b5b5b5',
                            pearl: '#e5e5e5',
                            snow: '#f5f5f5',
                            white: '#fafafa',
                            red: '#c41e3a',
                            'red-dark': '#9b1830',
                            'red-light': '#e63950',
                            gold: '#c9a84c',
                            'gold-dark': '#b8933d',
                        },
                    },
                    boxShadow: {
                        'premium': '0 25px 50px -12px rgba(0,0,0,0.25)',
                        'premium-lg': '0 35px 60px -15px rgba(0,0,0,0.3)',
                        'glow-red': '0 0 30px rgba(196,30,58,0.15)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.7s ease-out forwards',
                        'scale-in': 'scaleIn 0.3s ease-out forwards',
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0', transform: 'translateY(12px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        scaleIn: { '0%': { opacity: '0', transform: 'scale(0.95)' }, '100%': { opacity: '1', transform: 'scale(1)' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                    },
                },
            },
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: localStorage.getItem('kitsuneoni_theme') !== 'light',
                toggle() { this.dark = !this.dark; localStorage.setItem('kitsuneoni_theme', this.dark ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', this.dark); },
                init() { document.documentElement.classList.toggle('dark', this.dark); }
            });
            Alpine.store('wishlist', {
                items: JSON.parse(localStorage.getItem('wishlist') || '[]'),
                get count() { return this.items.length; },
                has(productId) { return this.items.some(i => i.id === productId); },
                toggle(product) {
                    const idx = this.items.findIndex(i => i.id === product.id);
                    if (idx >= 0) { this.items.splice(idx, 1); } else { this.items.push({ id: product.id, name: product.name, slug: product.slug, price: product.price, image: product.image, url: product.url }); }
                    localStorage.setItem('wishlist', JSON.stringify(this.items));
                },
                clear() { this.items = []; localStorage.removeItem('wishlist'); }
            });
            Alpine.store('cart', {
                items: JSON.parse(localStorage.getItem('cart') || '[]'),
                get count() { return this.items.reduce((sum, item) => sum + item.quantity, 0); },
                get total() { return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0); },
                add(product, quantity = 1) {
                    const existing = this.items.find(i => i.id === product.id);
                    if (existing) { existing.quantity += quantity; } else { this.items.push({ ...product, quantity }); }
                    this.save();
                },
                remove(productId) { this.items = this.items.filter(i => i.id !== productId); this.save(); },
                clear() { this.items = []; this.save(); },
                save() { localStorage.setItem('cart', JSON.stringify(this.items)); }
            });

            Alpine.data('countrySelect', ({ old: oldValue, countries }) => ({
                open: false,
                query: '',
                selected: oldValue || '',
                all: countries || [],
                get filtered() {
                    const q = this.query.trim().toLowerCase();
                    if (!q) return this.all;
                    return this.all.filter(c => c.toLowerCase().includes(q));
                },
                select(country) {
                    this.selected = country;
                    this.query = '';
                    this.open = false;
                    Alpine.store('shipping').country = country;
                    Alpine.store('shipping').city = '';
                }
            }));

            Alpine.store('shipping', {
                country: <?php echo e(Js::from(old('customer_country'))); ?>,
                city: <?php echo e(Js::from(old('customer_city'))); ?>,
            });
        });
    </script>
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 0 0% 3.9%;
            --card: 0 0% 100%;
            --primary: 25 95% 53%;
            --primary-foreground: 0 0% 98%;
            --muted: 0 0% 96.1%;
            --muted-foreground: 0 0% 45.1%;
            --border: 0 0% 89.8%;
            --accent: 0 0% 96.1%;
            --destructive: 0 84.2% 60.2%;
        }
        .dark {
            --background: 240 6% 4%;
            --foreground: 0 0% 95%;
            --card: 240 6% 6%;
            --primary: 25 95% 53%;
            --primary-foreground: 0 0% 98%;
            --muted: 240 4% 10%;
            --muted-foreground: 0 0% 55%;
            --border: 240 4% 16%;
            --accent: 240 4% 10%;
            --destructive: 0 62.8% 30.6%;
        }

        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        html { scroll-behavior: smooth; }
        body { width: 100%; }
        #page-wrapper { width: 100%; }

        /* Brand logo: explicit sizing so it never collapses on mobile; crisp on any theme */
        .brand-logo {
            width: auto;
            height: 40px;
            max-width: 150px;
            display: block;
            image-rendering: -webkit-optimize-contrast;
        }
        @media (min-width: 640px) { .brand-logo { height: 46px; } }
        /* Theme-aware logo swap: bright gold on dark, deep bronze on light.
           Each variant is authored to be equally vivid on its background. */
        .brand-logo-light { display: none; }
        .brand-logo-dark  { display: block; }
        .dark .brand-logo-light { display: none; }
        .dark .brand-logo-dark  { display: block; }
        html:not(.dark) .brand-logo-light { display: block; }
        html:not(.dark) .brand-logo-dark  { display: none; }
        /* Subtle depth in dark mode only */
        .dark .brand-logo-dark {
            filter: drop-shadow(0 0 6px rgba(201, 168, 76, 0.25)) drop-shadow(0 1px 2px rgba(0, 0, 0, 0.4));
        }
        html:not(.dark) .brand-logo-light {
            filter: drop-shadow(0 1px 2px rgba(40, 26, 8, 0.25));
        }
        ::selection { background: hsl(var(--primary) / 0.2); color: hsl(var(--primary)); }
        .dark ::selection { background: hsl(var(--primary) / 0.3); color: #fff; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: hsl(var(--background)); }
        ::-webkit-scrollbar-thumb { background: hsl(var(--border)); border-radius: 9999px; }

        .glass-nav {
            background: hsl(var(--background) / 0.85) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }
        .glass {
            background: hsl(var(--background) / 0.6);
            backdrop-filter: blur(16px) saturate(150%);
            -webkit-backdrop-filter: blur(16px) saturate(150%);
        }

        .animate-fade-in {
            animation: fadeIn 0.7s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .blade-sheen { position: relative; overflow: hidden; }
        .blade-sheen::after {
            content: '';
            position: absolute;
            inset: 0;
            transform: translateX(-100%) skewX(-20deg);
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.12), transparent);
            transition: transform 0.7s ease-in-out;
            pointer-events: none;
        }
        .blade-sheen:hover::after {
            transform: translateX(100%) skewX(-20deg);
        }

        .text-balance { text-wrap: balance; }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.75rem 2rem; background: #c41e3a; color: white;
            font-size: 0.875rem; font-weight: 600; border-radius: 0.75rem;
            transition: all 0.3s; cursor: pointer; border: none;
            box-shadow: 0 0 20px rgba(196,30,58,0.25);
        }
        .btn-primary:hover { background: #9b1830; box-shadow: 0 0 35px rgba(196,30,58,0.4); transform: scale(1.02); }
        .btn-primary:active { transform: scale(0.98); }
        .btn-secondary {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.375rem;
            padding: 0.75rem 1.5rem; background: transparent;
            border: 1px solid hsl(var(--border)); color: hsl(var(--foreground));
            font-size: 0.875rem; font-weight: 500; border-radius: 0.75rem;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-secondary:hover { border-color: hsl(var(--primary)); color: hsl(var(--primary)); }

        .input-premium {
            width:100%; padding:0.625rem 0.875rem;
            background:hsl(var(--card));
            border:1px solid hsl(var(--border));
            border-radius:0.75rem;
            color:hsl(var(--foreground));
            font-size:0.875rem;
            outline:none;
            transition:all 0.2s;
        }
        .input-premium::placeholder { color:hsl(var(--muted-foreground) / 0.6); }
        .input-premium:focus { border-color:hsl(var(--primary) / 0.5); box-shadow:0 0 0 3px hsl(var(--primary) / 0.08); }
        select.input-premium {
            appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a8a8a' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat:no-repeat;
            background-position:right 0.75rem center;
            padding-right:2.25rem;
        }
        select.input-premium option { background:hsl(var(--card)); color:hsl(var(--foreground)); }
    </style>

    <?php if(config('site.analytics.google_analytics')): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('site.analytics.google_analytics')); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo e(config("site.analytics.google_analytics")); ?>');
    </script>
    <?php endif; ?>

    <?php echo $__env->yieldContent('head'); ?>
</head>
<body class="bg-background text-foreground antialiased min-h-screen flex flex-col" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 3000); window.addEventListener('load', () => setTimeout(() => loading = false, 800))">

    
    <div id="page-loader" x-show="loading" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-background">
        <div class="relative flex flex-col items-center">
            
            <div class="relative mb-7">
                <picture>
                    <source type="image/webp" srcset="<?php echo e(asset('storage/brand/logo.webp')); ?> 1x, <?php echo e(asset('storage/brand/logo@2x.webp')); ?> 2x">
                    <img src="<?php echo e(asset('storage/brand/logo.png')); ?>" width="512" height="512"
                         alt="Kitsuneoni" class="brand-logo brand-logo-dark w-auto object-contain animate-pulse"
                         style="height:80px;max-width:none;">
                </picture>
                <picture>
                    <source type="image/webp" srcset="<?php echo e(asset('storage/brand/logo-light.webp')); ?> 1x, <?php echo e(asset('storage/brand/logo-light@2x.webp')); ?> 2x">
                    <img src="<?php echo e(asset('storage/brand/logo-light.png')); ?>" width="512" height="512"
                         alt="Kitsuneoni" class="brand-logo brand-logo-light w-auto object-contain animate-pulse"
                         style="height:80px;max-width:none;">
                </picture>
            </div>
            
            <div class="flex flex-col items-center leading-none mb-6">
                <span class="font-heading text-3xl font-light tracking-[0.3em] text-foreground">KITSUNE</span>
                <span class="font-heading text-[10px] tracking-[0.6em] text-primary mt-2">— ONI —</span>
            </div>
            
            <div class="w-64 sm:w-80 max-w-[80vw] h-[2px] bg-border relative overflow-hidden rounded-full">
                <div class="absolute inset-0 bg-primary animate-loader-bar"></div>
            </div>
            <p class="text-[10px] tracking-[0.3em] uppercase text-muted-foreground mt-4 animate-pulse">Forging steel...</p>
        </div>
        <style>
            @keyframes sword-swipe { 0%, 100% { transform: translateY(-100%); } 50% { transform: translateY(100%); } }
            @keyframes loader-bar { 0% { transform: translateX(-100%); } 100% { transform: translateX(200%); } }
            .animate-sword-swipe { animation: sword-swipe 2s ease-in-out infinite; }
            .animate-loader-bar { animation: loader-bar 1.5s ease-in-out infinite; }
        </style>
    </div>
    <script>
        (function () {
            var hide = function () {
                var l = document.getElementById('page-loader');
                if (l) { l.style.opacity = '0'; setTimeout(function () { l.style.display = 'none'; }, 500); }
            };
            window.addEventListener('load', function () { setTimeout(hide, 800); });
            setTimeout(hide, 3500);
        })();
    </script>

    <!-- Navigation -->
    <header x-data="{ scrolled: false, mobileMenuOpen: false, searchOpen: false }"
            x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 border-b"
            :class="scrolled || mobileMenuOpen ? 'glass-nav border-border/50' : 'bg-transparent border-transparent'"
            id="main-nav">

        <nav class="max-w-[1440px] mx-auto px-6 lg:px-12">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="<?php echo e(route('home')); ?>" class="flex items-center group" aria-label="Kitsuneoni — Home">
                    <picture>
                        <source type="image/webp" srcset="<?php echo e(asset('storage/brand/logo.webp')); ?> 1x, <?php echo e(asset('storage/brand/logo@2x.webp')); ?> 2x">
                        <img src="<?php echo e(asset('storage/brand/logo.png')); ?>"
                             srcset="<?php echo e(asset('storage/brand/logo@2x.png')); ?> 2x"
                             width="512" height="512" fetchpriority="high"
                             alt="Kitsuneoni — Handcrafted Japanese Blades & Collectibles"
                             class="brand-logo brand-logo-dark w-auto object-contain transition-transform duration-500 group-hover:scale-[1.04]">
                    </picture>
                    <picture>
                        <source type="image/webp" srcset="<?php echo e(asset('storage/brand/logo-light.webp')); ?> 1x, <?php echo e(asset('storage/brand/logo-light@2x.webp')); ?> 2x">
                        <img src="<?php echo e(asset('storage/brand/logo-light.png')); ?>"
                             srcset="<?php echo e(asset('storage/brand/logo-light@2x.png')); ?> 2x"
                             width="512" height="512" fetchpriority="high"
                             alt="Kitsuneoni — Handcrafted Japanese Blades & Collectibles"
                             class="brand-logo brand-logo-light w-auto object-contain transition-transform duration-500 group-hover:scale-[1.04]">
                    </picture>
                </a>

                <!-- Desktop Navigation (centered) -->
                <div class="hidden lg:flex items-center gap-6 xl:gap-10 absolute left-1/2 -translate-x-1/2">
                    <a href="<?php echo e(route('home')); ?>" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 <?php echo e(request()->routeIs('home') ? 'text-foreground' : ''); ?>">Home</a>
                    <a href="<?php echo e(route('shop.index')); ?>" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 <?php echo e(request()->routeIs('shop.*') ? 'text-foreground' : ''); ?>">Shop</a>
                    <a href="<?php echo e(route('about')); ?>" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 <?php echo e(request()->routeIs('about') ? 'text-foreground' : ''); ?>">About</a>
                    <a href="<?php echo e(route('loyalty')); ?>" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 <?php echo e(request()->routeIs('loyalty') ? 'text-foreground' : ''); ?>">Loyalty</a>
                    <a href="<?php echo e(route('contact')); ?>" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 <?php echo e(request()->routeIs('contact') ? 'text-foreground' : ''); ?>">Contact</a>
                    <a href="<?php echo e(route('faq')); ?>" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 <?php echo e(request()->routeIs('faq') ? 'text-foreground' : ''); ?>">FAQ</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-5">
                    <!-- Search (visible field on desktop) -->
                    <div class="hidden md:flex items-center">
                        <form action="<?php echo e(route('shop.index')); ?>" method="GET" class="relative" role="search">
                            <input type="text" name="q" placeholder="Search katanas..." aria-label="Search products"
                                   class="w-40 xl:w-56 bg-background/70 border border-border/60 rounded-full pl-4 pr-9 py-2 text-xs text-foreground placeholder:text-muted-foreground/60 focus:outline-none focus:border-primary/60 focus:ring-2 focus:ring-primary/10 transition-all">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-primary transition-colors" aria-label="Search">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Search (icon on mobile — opens overlay) -->
                    <button @click="searchOpen = !searchOpen" class="md:hidden text-muted-foreground hover:text-foreground transition-colors duration-300" aria-label="Search">
                        <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    <!-- Wishlist -->
                    <a href="<?php echo e(route('wishlist')); ?>" class="relative text-muted-foreground hover:text-foreground transition-colors duration-300" aria-label="Wishlist">
                        <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count" class="absolute -top-1.5 -right-1.5 min-w-[16px] h-4 px-1 bg-primary text-primary-foreground text-[10px] font-bold rounded-full flex items-center justify-center"></span>
                    </a>

                    <!-- Theme Toggle -->
                    <button @click="$store.theme.toggle()" class="text-muted-foreground hover:text-foreground transition-colors duration-300" aria-label="Toggle theme">
                        <svg x-show="!$store.theme.dark" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="$store.theme.dark" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    <!-- Order Now CTA -->
                    <a href="<?php echo e(route('order.create')); ?>" class="inline-flex items-center gap-2 bg-[#c41e3a] text-white px-3 sm:px-6 py-2.5 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-lg shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                        <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                        <span class="hidden sm:inline">Order Now</span>
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden flex items-center justify-center w-11 h-11 bg-[#c41e3a] text-white rounded-lg hover:bg-[#9b1830] transition-all shadow-[0_0_15px_rgba(196,30,58,0.3)]" aria-label="Menu">
                        <svg x-show="!mobileMenuOpen" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                        <svg x-show="mobileMenuOpen" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Search Overlay (full-screen) -->
        <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60]" x-cloak>
            <div class="absolute inset-0 bg-background/90 backdrop-blur-xl" @click="searchOpen = false"></div>
            <div class="relative max-w-2xl mx-auto pt-32 px-6">
                <div x-data="{ query: '', results: [], loading: false }">
                    <div class="flex items-center gap-4 border-b border-border pb-4">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="text-muted-foreground shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" x-model="query" @input.debounce.300ms="
                            loading = true;
                            fetch('/search?q=' + query)
                                .then(r => r.json())
                                .then(d => { results = d.results; loading = false; })
                                .catch(() => loading = false)
                        " placeholder="Search for katanas, series, steel types..." class="flex-1 bg-transparent text-2xl font-heading font-light focus:outline-none placeholder:text-muted-foreground/50 text-foreground">
                        <button @click="searchOpen = false" class="text-muted-foreground hover:text-foreground transition-colors" aria-label="Close search">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div x-show="results.length > 0" class="mt-6 space-y-2 max-h-80 overflow-y-auto">
                        <template x-for="result in results" :key="result.id">
                            <a :href="result.url" class="flex items-center gap-4 p-3 rounded-xl hover:bg-accent transition-colors">
                                <img :src="result.image" :alt="result.name" class="w-12 h-12 rounded-lg object-cover">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-foreground truncate" x-text="result.name"></p>
                                    <p class="text-xs text-muted-foreground" x-text="result.category"></p>
                                </div>
                                <span class="text-sm font-mono text-primary" x-text="result.price"></span>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (sticky dropdown below nav) -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="absolute top-full left-0 right-0 bg-background border-b border-border lg:hidden shadow-xl max-h-[calc(100vh-5rem)] overflow-y-auto" x-cloak>
            <div class="px-6 py-6 space-y-0">
                <?php $__currentLoopData = [['Home', route('home')], ['Shop', route('shop.index')], ['About', route('about')], ['Contact', route('contact')], ['Loyalty', route('loyalty')], ['FAQ', route('faq')], ['Wishlist', route('wishlist')], ['Order Now', route('order.create')]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $url]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($url); ?>" @click="mobileMenuOpen = false" class="flex items-center justify-between border-b border-border py-5 group">
                    <span class="font-heading text-2xl font-light text-foreground group-hover:text-primary transition-colors"><?php echo e($label); ?></span>
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="text-muted-foreground"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </header>

    <!-- Spacer for fixed header -->
    <div class="h-20 shrink-0"></div>

    <!-- Main Content -->
    <main class="flex-1" id="page-wrapper">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-card border-t border-border">
        <!-- Newsletter Section -->
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-16 sm:py-24 border-b border-border">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Stay Connected</p>
                <h2 class="font-heading text-4xl lg:text-5xl font-light mb-4 text-balance text-foreground">Join the inner circle</h2>
                <p class="text-muted-foreground text-sm mb-8 leading-relaxed">Be the first to know about new arrivals, exclusive pieces, and private commissions. No noise &mdash; only steel.</p>
                <form action="<?php echo e(route('newsletter.subscribe')); ?>" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" x-data="{ loading: false }" @submit="loading = true">
                    <?php echo csrf_field(); ?>
                    <input type="email" name="email" required placeholder="Enter your email" class="w-full sm:flex-1 px-5 py-3.5 bg-muted border border-border rounded-none text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-all">
                    <button type="submit" :disabled="loading" class="px-6 py-3.5 bg-[#c41e3a] text-white text-[11px] tracking-[0.3em] uppercase font-semibold rounded-lg shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 disabled:opacity-50 shrink-0">
                        <span x-show="!loading">Subscribe</span>
                        <svg x-show="loading" class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Links Grid -->
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-16">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12">
                <!-- Brand -->
                <div class="col-span-2 lg:col-span-1">
                    <a href="<?php echo e(route('home')); ?>" class="block mb-6 group" aria-label="Kitsuneoni — Home">
                        <picture>
                            <source type="image/webp" srcset="<?php echo e(asset('storage/brand/logo.webp')); ?> 1x, <?php echo e(asset('storage/brand/logo@2x.webp')); ?> 2x">
                            <img src="<?php echo e(asset('storage/brand/logo.png')); ?>"
                                 srcset="<?php echo e(asset('storage/brand/logo@2x.png')); ?> 2x"
                                 width="512" height="512" loading="lazy"
                                 alt="Kitsuneoni — Handcrafted Japanese Blades & Collectibles"
                                 class="brand-logo brand-logo-dark w-auto object-contain transition-transform duration-500 group-hover:scale-[1.04]">
                        </picture>
                        <picture>
                            <source type="image/webp" srcset="<?php echo e(asset('storage/brand/logo-light.webp')); ?> 1x, <?php echo e(asset('storage/brand/logo-light@2x.webp')); ?> 2x">
                            <img src="<?php echo e(asset('storage/brand/logo-light.png')); ?>"
                                 srcset="<?php echo e(asset('storage/brand/logo-light@2x.png')); ?> 2x"
                                 width="512" height="512" loading="lazy"
                                 alt="Kitsuneoni — Handcrafted Japanese Blades & Collectibles"
                                 class="brand-logo brand-logo-light w-auto object-contain transition-transform duration-500 group-hover:scale-[1.04]">
                        </picture>
                    </a>
                    <p class="text-sm text-muted-foreground leading-relaxed max-w-xs">Japanese blades, made the old way. No shortcuts, just fire and steel.</p>
                    <div class="flex gap-3 mt-6">
                        <a href="mailto:<?php echo e(config('site.contact.email')); ?>" class="w-10 h-10 flex items-center justify-center border border-border rounded-full text-muted-foreground hover:text-foreground hover:border-primary transition-all" aria-label="Email">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Collections -->
                <div>
                    <h3 class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground mb-5">Collections</h3>
                    <ul class="space-y-3">
                        <li><a href="<?php echo e(route('shop.index')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">All Pieces</a></li>
                        <li><a href="<?php echo e(route('shop.index', ['sort' => 'newest'])); ?>" class="text-sm hover:text-primary transition-colors text-foreground">New Arrivals</a></li>
                        <li><a href="<?php echo e(route('shop.index', ['sort' => 'popular'])); ?>" class="text-sm hover:text-primary transition-colors text-foreground">Best Sellers</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground mb-5">Company</h3>
                    <ul class="space-y-3">
                        <li><a href="<?php echo e(route('about')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">About Us</a></li>
                        <li><a href="<?php echo e(route('faq')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">FAQ</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">Contact</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground mb-5">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="<?php echo e(route('faq')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">Shipping Info</a></li>
                        <li><a href="<?php echo e(route('order.create')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">Order Process</a></li>
                        <li><a href="<?php echo e(route('contact')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">Contact Us</a></li>
                        <li><a href="<?php echo e(route('loyalty')); ?>" class="text-sm hover:text-primary transition-colors text-foreground">Loyalty Program</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="border-t border-border">
            <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-muted-foreground tracking-wide">&copy; Kitsuneoni. All rights reserved.</p>
                <p class="text-xs text-muted-foreground tracking-wide font-mono">Forged by hand. Delivered worldwide.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="back-to-top" @click="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 z-50 w-11 h-11 bg-[#c41e3a] text-white flex items-center justify-center rounded-full shadow-[0_0_20px_rgba(196,30,58,0.3)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.5)] hover:scale-110 active:scale-95 transition-all duration-300 opacity-0 pointer-events-none" aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
    </button>

    <!-- Toast Notifications -->
    <?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-3 bg-green-600 text-white text-sm font-medium flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <!-- Back to Top + Toast script -->
    <script>
        const btt = document.getElementById('back-to-top');
        if (btt) {
            window.addEventListener('scroll', () => {
                btt.style.opacity = window.scrollY > 400 ? '1' : '0';
                btt.style.pointerEvents = window.scrollY > 400 ? 'auto' : 'none';
            });
        }
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views/layouts/app.blade.php ENDPATH**/ ?>