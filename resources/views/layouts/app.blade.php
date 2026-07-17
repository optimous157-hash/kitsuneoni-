<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" x-data x-init="$store.theme.init()" :class="$store.theme.dark ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0A0A0B">

    <title>@yield('title', config('site.seo.title'))</title>
    <meta name="description" content="@yield('description', config('site.seo.description'))">
    <meta name="keywords" content="@yield('keywords', config('site.seo.keywords'))">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:title" content="@yield('og_title', config('site.seo.title'))">
    <meta property="og:description" content="@yield('og_description', config('site.seo.description'))">
    <meta property="og:image" content="@yield('og_image', config('site.seo.og_image'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('og_image_alt', config('site.seo.title'))">
    <meta property="og:site_name" content="Kitsuneoni">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Yamagataaa">
    <meta name="twitter:creator" content="@Yamagataaa">
    <meta name="twitter:title" content="@yield('og_title', config('site.seo.title'))">
    <meta name="twitter:description" content="@yield('og_description', config('site.seo.description'))">
    <meta name="twitter:image" content="@yield('og_image', config('site.seo.og_image'))">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Kitsuneoni",
        "url": "{{ url('/') }}",
        "description": "{{ config('site.seo.description') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "email": "{{ config('site.contact.email') }}",
            "contactType": "customer service"
        }
    }
    </script>
    @yield('page_json_ld')

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

    @if(config('site.analytics.google_analytics'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('site.analytics.google_analytics') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config("site.analytics.google_analytics") }}');
    </script>
    @endif

    @yield('head')
</head>
<body class="bg-background text-foreground antialiased min-h-screen flex flex-col" x-data="{ loading: true }" x-init="window.addEventListener('load', () => setTimeout(() => loading = false, 800))">

    {{-- Page Loader --}}
    <div x-show="loading" x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-background">
        <div class="relative flex flex-col items-center">
            {{-- Animated katana icon --}}
            <div class="relative w-16 h-32 mb-8">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-24 text-primary" viewBox="0 0 24 80" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 0 L4 80 L12 70 L20 80 Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="12" y1="0" x2="12" y2="75" stroke-width="1" opacity="0.3"/>
                    </svg>
                </div>
                <div class="absolute inset-0 flex items-center justify-center overflow-hidden">
                    <div class="w-16 h-full bg-gradient-to-b from-transparent via-primary/20 to-transparent animate-sword-swipe"></div>
                </div>
            </div>
            {{-- Brand name --}}
            <div class="flex flex-col items-center leading-none mb-6">
                <span class="font-heading text-3xl font-light tracking-[0.3em] text-foreground">KITSUNE</span>
                <span class="font-heading text-[10px] tracking-[0.6em] text-primary mt-2">— ONI —</span>
            </div>
            {{-- Loading bar --}}
            <div class="w-48 h-px bg-border relative overflow-hidden rounded-full">
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

    <!-- Navigation -->
    <header x-data="{ scrolled: false, mobileMenuOpen: false, searchOpen: false }"
            x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 border-b"
            :class="scrolled ? 'glass-nav border-border/50' : 'bg-transparent border-transparent'"
            id="main-nav">

        <nav class="max-w-[1440px] mx-auto px-6 lg:px-12">
            <div class="flex items-center justify-between h-20">
                <!-- Logo (Stacked) -->
                <a href="{{ route('home') }}" class="flex flex-col leading-none group" aria-label="Kitsuneoni Home">
                    <span class="font-heading text-2xl font-light tracking-[0.25em] group-hover:text-primary transition-colors text-foreground">
                        KITSUNE
                    </span>
                    <span class="font-heading text-[10px] tracking-[0.5em] text-primary mt-0.5">
                        — ONI —
                    </span>
                </a>

                <!-- Desktop Navigation (centered) -->
                <div class="hidden lg:flex items-center gap-10 absolute left-1/2 -translate-x-1/2">
                    <a href="{{ route('home') }}" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 {{ request()->routeIs('home') ? 'text-foreground' : '' }}">Home</a>
                    <a href="{{ route('shop.index') }}" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 {{ request()->routeIs('shop.*') ? 'text-foreground' : '' }}">Shop</a>
                    <a href="{{ route('about') }}" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 {{ request()->routeIs('about') ? 'text-foreground' : '' }}">About</a>
                    <a href="{{ route('loyalty') }}" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 {{ request()->routeIs('loyalty') ? 'text-foreground' : '' }}">Loyalty</a>
                    <a href="{{ route('faq') }}" class="text-[13px] tracking-wide uppercase text-muted-foreground hover:text-foreground transition-colors duration-300 {{ request()->routeIs('faq') ? 'text-foreground' : '' }}">FAQ</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-5">
                    <!-- Search -->
                    <button @click="searchOpen = !searchOpen" class="text-muted-foreground hover:text-foreground transition-colors duration-300" aria-label="Search">
                        <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist') }}" class="relative text-muted-foreground hover:text-foreground transition-colors duration-300" aria-label="Wishlist">
                        <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span x-show="$store.wishlist.count > 0" x-text="$store.wishlist.count" class="absolute -top-1.5 -right-1.5 min-w-[16px] h-4 px-1 bg-primary text-primary-foreground text-[10px] font-bold rounded-full flex items-center justify-center"></span>
                    </a>

                    <!-- Theme Toggle -->
                    <button @click="$store.theme.toggle()" class="text-muted-foreground hover:text-foreground transition-colors duration-300" aria-label="Toggle theme">
                        <svg x-show="!$store.theme.dark" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="$store.theme.dark" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    <!-- Order Now CTA -->
                    <a href="{{ route('order.create') }}" class="hidden sm:inline-flex items-center gap-2 bg-[#c41e3a] text-white px-6 py-2.5 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-lg shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                        Order Now
                    </a>

                    <!-- Mobile Menu Toggle -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-muted-foreground hover:text-foreground transition-colors" aria-label="Menu">
                        <svg x-show="!mobileMenuOpen" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
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

        <!-- Mobile Menu (full-screen overlay) -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[60] bg-background lg:hidden" x-cloak>
            <div class="flex items-center justify-between h-20 px-6 border-b border-border">
                <span class="font-heading text-2xl font-light tracking-[0.25em] text-foreground">KITSUNEONI</span>
                <button @click="mobileMenuOpen = false" class="text-muted-foreground hover:text-foreground transition-colors" aria-label="Close menu">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-12 space-y-0">
                @foreach([['Home', route('home')], ['Shop', route('shop.index')], ['About', route('about')], ['Loyalty', route('loyalty')], ['FAQ', route('faq')], ['Wishlist', route('wishlist')], ['Order Now', route('order.create')]] as [$label, $url])
                <a href="{{ $url }}" class="flex items-center justify-between border-b border-border py-5 group">
                    <span class="font-heading text-3xl font-light text-foreground group-hover:text-primary transition-colors">{{ $label }}</span>
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="text-muted-foreground"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endforeach
            </div>
        </div>
    </header>

    <!-- Spacer for fixed header -->
    <div class="h-20 shrink-0"></div>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-card border-t border-border">
        <!-- Newsletter Section -->
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-24 border-b border-border">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Stay Connected</p>
                <h2 class="font-heading text-4xl lg:text-5xl font-light mb-4 text-balance text-foreground">Join the inner circle</h2>
                <p class="text-muted-foreground text-sm mb-8 leading-relaxed">Be the first to know about new arrivals, exclusive pieces, and private commissions. No noise &mdash; only steel.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-3 max-w-md mx-auto" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    <input type="email" name="email" required placeholder="Enter your email" class="flex-1 px-5 py-3.5 bg-muted border border-border rounded-none text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-all">
                    <button type="submit" :disabled="loading" class="px-6 py-3.5 bg-[#c41e3a] text-white text-[11px] tracking-[0.3em] uppercase font-semibold rounded-lg shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 disabled:opacity-50 shrink-0">
                        <span x-show="!loading">Subscribe</span>
                        <svg x-show="loading" class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Links Grid -->
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-16">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="col-span-2 lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex flex-col leading-none mb-6 group">
                        <span class="font-heading text-2xl font-light tracking-[0.25em] group-hover:text-primary transition-colors text-foreground">KITSUNE</span>
                        <span class="font-heading text-[10px] tracking-[0.5em] text-primary mt-0.5">— ONI —</span>
                    </a>
                    <p class="text-sm text-muted-foreground leading-relaxed max-w-xs">Handcrafted Japanese blades for the modern collector. Each piece forged by hand. Shipped worldwide.</p>
                    <div class="flex gap-3 mt-6">
                        <a href="{{ config('site.contact.telegram') }}" target="_blank" class="w-10 h-10 flex items-center justify-center border border-border rounded-full text-muted-foreground hover:text-foreground hover:border-primary transition-all" aria-label="Telegram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        </a>
                        <a href="{{ config('site.contact.instagram') }}" target="_blank" class="w-10 h-10 flex items-center justify-center border border-border rounded-full text-muted-foreground hover:text-foreground hover:border-primary transition-all" aria-label="Instagram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="{{ config('site.contact.whatsapp') }}" target="_blank" class="w-10 h-10 flex items-center justify-center border border-border rounded-full text-muted-foreground hover:text-foreground hover:border-primary transition-all" aria-label="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Collections -->
                <div>
                    <h3 class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground mb-5">Collections</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop.index') }}" class="text-sm hover:text-primary transition-colors text-foreground">All Pieces</a></li>
                        <li><a href="{{ route('shop.index', ['sort' => 'newest']) }}" class="text-sm hover:text-primary transition-colors text-foreground">New Arrivals</a></li>
                        <li><a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="text-sm hover:text-primary transition-colors text-foreground">Best Sellers</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground mb-5">Company</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-sm hover:text-primary transition-colors text-foreground">About Us</a></li>
                        <li><a href="{{ route('faq') }}" class="text-sm hover:text-primary transition-colors text-foreground">FAQ</a></li>
                        <li><a href="{{ config('site.contact.telegram') }}" target="_blank" class="text-sm hover:text-primary transition-colors text-foreground">Contact</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-[11px] tracking-[0.3em] uppercase text-muted-foreground mb-5">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('shop.index') }}" class="text-sm hover:text-primary transition-colors text-foreground">Shipping Info</a></li>
                        <li><a href="{{ route('order.create') }}" class="text-sm hover:text-primary transition-colors text-foreground">Order Process</a></li>
                        <li><a href="{{ config('site.contact.telegram') }}" target="_blank" class="text-sm hover:text-primary transition-colors text-foreground">Live Chat</a></li>
                        <li><a href="{{ route('loyalty') }}" class="text-sm hover:text-primary transition-colors text-foreground">Loyalty Program</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright Bar -->
        <div class="border-t border-border">
            <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-muted-foreground tracking-wide">&copy; {{ date('Y') }} Kitsuneoni. All rights reserved.</p>
                <p class="text-xs text-muted-foreground tracking-wide font-mono">Forged by hand. Delivered worldwide.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <button id="back-to-top" @click="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 z-50 w-11 h-11 bg-[#c41e3a] text-white flex items-center justify-center rounded-full shadow-[0_0_20px_rgba(196,30,58,0.3)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.5)] hover:scale-110 active:scale-95 transition-all duration-300 opacity-0 pointer-events-none" aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
    </button>

    <!-- Toast Notifications -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-3 bg-green-600 text-white text-sm font-medium flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

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

    @yield('scripts')
</body>
</html>