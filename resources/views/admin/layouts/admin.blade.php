<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Kitsuneoni</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        /* Admin Layout */
        .admin-sidebar { position:fixed; top:0; left:0; bottom:0; width:260px; background:#0a0a0a; border-right:1px solid rgba(42,42,42,0.5); display:flex; flex-direction:column; z-index:50; }
        .admin-content { margin-left:260px; min-height:100vh; }
        @media (max-width:1023px) { .admin-sidebar { transform:translateX(-100%); } .admin-sidebar.open { transform:translateX(0); } .admin-content { margin-left:0; } }

        /* Cards & Containers */
        .admin-card { background:rgba(17,17,17,0.6); border:1px solid rgba(42,42,42,0.5); border-radius:1rem; padding:1.5rem; backdrop-filter:blur(12px); }
        .admin-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; padding-bottom:1rem; border-bottom:1px solid rgba(42,42,42,0.4); }
        .admin-card-header h2 { font-size:1rem; font-weight:600; color:#fafafa; }
        .admin-stat { background:rgba(17,17,17,0.6); border:1px solid rgba(42,42,42,0.5); border-radius:1rem; padding:1.25rem 1.5rem; backdrop-filter:blur(12px); transition:all 0.2s; }
        .admin-stat:hover { border-color:rgba(42,42,42,0.8); }

        /* Tables */
        .admin-table { width:100%; font-size:0.875rem; }
        .admin-table thead { border-bottom:1px solid rgba(42,42,42,0.5); }
        .admin-table th { text-align:left; padding:0.75rem 1rem; font-weight:500; color:#8a8a8a; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; }
        .admin-table td { padding:0.875rem 1rem; border-bottom:1px solid rgba(42,42,42,0.25); color:#b5b5b5; vertical-align:middle; }
        .admin-table tbody tr { transition:background 0.15s; }
        .admin-table tbody tr:hover { background:rgba(26,26,26,0.4); }
        .admin-table tbody tr:last-child td { border-bottom:none; }

        /* Badges */
        .admin-badge { display:inline-flex; align-items:center; padding:0.25rem 0.625rem; border-radius:0.5rem; font-size:0.75rem; font-weight:500; line-height:1; }
        .admin-badge-pending { background:rgba(234,179,8,0.1); color:#facc15; }
        .admin-badge-confirmed { background:rgba(59,130,246,0.1); color:#60a5fa; }
        .admin-badge-processing { background:rgba(168,85,247,0.1); color:#c084fc; }
        .admin-badge-delivered { background:rgba(34,197,94,0.1); color:#4ade80; }
        .admin-badge-cancelled { background:rgba(239,68,68,0.1); color:#f87171; }
        .admin-badge-active { background:rgba(34,197,94,0.1); color:#4ade80; }
        .admin-badge-draft { background:rgba(113,113,122,0.1); color:#a1a1aa; }
        .admin-badge-gold { background:rgba(201,168,76,0.15); color:#c9a84c; }
        .admin-badge-silver { background:rgba(161,161,170,0.1); color:#a1a1aa; }
        .admin-badge-bronze { background:rgba(180,120,80,0.1); color:#d4a574; }

        /* Form Elements */
        .input-premium { width:100%; padding:0.625rem 0.875rem; background:rgba(26,26,26,0.6); border:1px solid rgba(42,42,42,0.6); border-radius:0.75rem; color:#fafafa; font-size:0.875rem; outline:none; transition:all 0.2s; }
        .input-premium::placeholder { color:#3a3a3a; }
        .input-premium:focus { border-color:rgba(196,30,58,0.4); box-shadow:0 0 0 3px rgba(196,30,58,0.08); }
        select.input-premium { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a8a8a' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 0.75rem center; padding-right:2.25rem; }
        select.input-premium option { background:#1a1a1a; color:#e5e5e5; }

        /* Buttons */
        .btn-primary { display:inline-flex; align-items:center; justify-content:center; gap:0.5rem; padding:0.625rem 1.5rem; background:#c41e3a; color:white; font-size:0.875rem; font-weight:600; border-radius:0.75rem; transition:all 0.3s; cursor:pointer; border:none; box-shadow:0 0 20px rgba(196,30,58,0.25); }
        .btn-primary:hover { background:#9b1830; box-shadow:0 0 35px rgba(196,30,58,0.4); transform:scale(1.02); }
        .btn-primary:active { transform:scale(0.98); }
        .btn-secondary { display:inline-flex; align-items:center; justify-content:center; gap:0.375rem; padding:0.625rem 1.25rem; background:transparent; border:1px solid rgba(42,42,42,0.6); color:#b5b5b5; font-size:0.875rem; font-weight:500; border-radius:0.75rem; transition:all 0.2s; cursor:pointer; }
        .btn-secondary:hover { border-color:rgba(42,42,42,1); color:#fafafa; background:rgba(26,26,26,0.4); }
        .btn-danger { display:inline-flex; align-items:center; justify-content:center; gap:0.375rem; padding:0.625rem 1.25rem; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#f87171; font-size:0.875rem; font-weight:500; border-radius:0.75rem; transition:all 0.2s; cursor:pointer; }
        .btn-danger:hover { background:rgba(239,68,68,0.2); border-color:rgba(239,68,68,0.4); }

        /* Misc */
        .admin-divider { height:1px; background:rgba(42,42,42,0.4); }
        .admin-empty { padding:3rem; text-align:center; color:#3a3a3a; }
        .admin-empty svg { width:3rem; height:3rem; margin:0 auto 0.75rem; }
        [x-cloak] { display:none !important; }
    </style>
</head>
<body class="bg-[#080808] text-yamagata-pearl min-h-screen font-sans" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'open' : ''" class="admin-sidebar">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="p-5 border-b border-yamagata-graphite/40">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-yamagata-red rounded-xl flex items-center justify-center shadow-lg shadow-yamagata-red/20">
                        <span class="text-white font-bold font-japanese text-sm">鬼</span>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-sm font-display font-bold text-white tracking-wide">KITSUNEONI</span>
                        <span class="text-[10px] font-medium text-yamagata-red tracking-widest uppercase">Admin</span>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <div class="pt-4 pb-1.5 px-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-yamagata-steel">Catalog</p>
                </div>

                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Categories
                </a>

                <div class="pt-4 pb-1.5 px-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-yamagata-steel">Sales</p>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Orders
                    @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                    <span class="ml-auto px-1.5 py-0.5 text-[10px] font-bold bg-yamagata-red/20 text-yamagata-red rounded-md">{{ $pendingOrdersCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.customers.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    Customers
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reviews.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Reviews
                </a>

                <div class="pt-4 pb-1.5 px-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-yamagata-steel">Content</p>
                </div>

                <a href="{{ route('admin.content.sections') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.content.sections') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    Page Sections
                </a>

                <a href="{{ route('admin.content.faqs') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.content.faqs') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    FAQs
                </a>

                <a href="{{ route('admin.newsletter.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.newsletter.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Newsletter
                </a>

                <div class="pt-4 pb-1.5 px-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-yamagata-steel">System</p>
                </div>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-yamagata-red/10 text-yamagata-red' : 'text-yamagata-silver hover:text-white hover:bg-white/[0.03]' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>
            </nav>

            <!-- User -->
            <div class="p-3 border-t border-yamagata-graphite/40">
                <div class="flex items-center gap-3 px-2 py-2">
                    <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-lg object-cover ring-2 ring-yamagata-graphite/50" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-yamagata-steel">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="p-1.5 text-yamagata-steel hover:text-yamagata-red rounded-lg hover:bg-yamagata-red/10 transition-all" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 z-40 lg:hidden" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak></div>

    <!-- Main -->
    <div class="admin-content">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 bg-[#080808]/80 backdrop-blur-xl border-b border-yamagata-graphite/30">
            <div class="flex items-center justify-between px-6 py-3">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 -ml-2 text-yamagata-silver hover:text-white rounded-lg hover:bg-white/[0.03] transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    @hasSection('breadcrumb')
                    <nav class="hidden sm:flex items-center gap-1.5 text-sm">
                        @yield('breadcrumb')
                    </nav>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-yamagata-silver hover:text-white rounded-lg hover:bg-white/[0.03] transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        View Site
                    </a>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="mb-4 p-3.5 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm flex items-center gap-2.5" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="flex-1">{{ session('success') }}</span>
                <button @click="show = false" class="shrink-0 p-0.5 hover:bg-green-500/10 rounded"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 p-3.5 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center gap-2.5">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="p-6">
            @yield('admin-content')
        </div>
    </div>

    @yield('admin-scripts')
</body>
</html>
