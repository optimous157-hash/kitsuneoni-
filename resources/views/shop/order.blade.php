@extends('layouts.app')

@section('title', 'Order — Kitsuneoni')
@section('description', 'Place your order for handcrafted Kitsuneoni blades. No payment required upfront — we confirm via email within 24 hours.')
@section('og_title', 'Order — Kitsuneoni')
@section('og_description', 'Place your order for handcrafted Kitsuneoni blades. No payment required upfront.')

@section('content')

<section class="py-24 lg:py-32">
    <div class="max-w-2xl mx-auto px-6 lg:px-12">

        <div class="text-center mb-12">
            <p class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4">Place Your Order</p>
            <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-4">Order Now</h1>
            <p class="text-sm text-muted-foreground max-w-md mx-auto leading-relaxed">Fill in the form below and we'll confirm your order via email within 24 hours. No payment required upfront.</p>
        </div>

        @if($errors->any())
        <div class="mb-8 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
            <p class="text-sm text-red-600 dark:text-red-400 font-medium">Please fix the errors below.</p>
        </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST" x-data="{ loading: false }" @submit="loading = true" class="space-y-6">

            {{-- Selected Product --}}
            @if($product)
            <div class="bg-card border border-border p-6 rounded-2xl">
                <div class="flex items-start gap-4">
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-xl object-cover shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] text-primary font-semibold tracking-wider uppercase mb-1">{{ $product->category->name ?? 'Collection' }}</p>
                        <h3 class="text-lg font-medium text-foreground">{{ $product->name }}</h3>
                        <p class="text-xl font-bold text-foreground mt-1">{{ $product->formatted_price }}</p>
                    </div>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="mt-4 pt-4 border-t border-border">
                    <label class="block text-sm font-medium text-foreground mb-2">Quantity</label>
                    <div class="flex items-center gap-1 w-fit">
                        <button type="button" @click="$refs.qty.value = Math.max(1, parseInt($refs.qty.value) - 1); $dispatch('change')" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">−</button>
                        <input type="number" name="quantity" x-ref="qty" value="{{ old('quantity', 1) }}" min="1" max="10" readonly class="w-16 h-10 text-center bg-transparent border-none text-lg font-bold text-foreground focus:outline-none">
                        <button type="button" @click="$refs.qty.value = Math.min(10, parseInt($refs.qty.value) + 1); $dispatch('change')" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">+</button>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-card border border-border p-6 rounded-2xl">
                <h3 class="text-sm font-medium text-foreground mb-3">Select Product <span class="text-primary">*</span></h3>
                <select name="product_id" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground focus:outline-none focus:border-primary transition-colors text-sm" required>
                    <option value="">Choose a product...</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }} — {{ $p->formatted_price }}
                    </option>
                    @endforeach
                </select>
                @error('product_id')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <div class="mt-4 pt-4 border-t border-border">
                    <label class="block text-sm font-medium text-foreground mb-2">Quantity</label>
                    <div class="flex items-center gap-1 w-fit">
                        <button type="button" @click="$refs.qty2.value = Math.max(1, parseInt($refs.qty2.value) - 1)" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">−</button>
                        <input type="number" name="quantity" x-ref="qty2" value="{{ old('quantity', 1) }}" min="1" max="10" readonly class="w-16 h-10 text-center bg-transparent border-none text-lg font-bold text-foreground focus:outline-none">
                        <button type="button" @click="$refs.qty2.value = Math.min(10, parseInt($refs.qty2.value) + 1)" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border text-foreground hover:bg-muted transition-colors text-lg font-bold">+</button>
                    </div>
                </div>
            </div>
            @endif

            {{-- Customer Information --}}
            <div class="bg-card border border-border p-6 rounded-2xl space-y-5">
                <h3 class="text-sm font-medium text-foreground mb-1">Your Information</h3>
                <p class="text-xs text-muted-foreground mb-4">We'll use this to confirm your order and send you updates.</p>

                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Full Name <span class="text-primary">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="e.g. John Smith">
                    @error('customer_name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Email <span class="text-primary">*</span></label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="your@email.com">
                        @error('customer_email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Phone <span class="text-primary">*</span></label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="+1 (555) 000-0000">
                        @error('customer_phone')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Shipping Information --}}
            <div class="bg-card border border-border p-6 rounded-2xl space-y-5">
                <h3 class="text-sm font-medium text-foreground mb-1">Shipping Details</h3>
                <p class="text-xs text-muted-foreground mb-4">Where should we send your order?</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Country <span class="text-primary">*</span></label>
                        <select name="customer_country" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground focus:outline-none focus:border-primary transition-colors text-sm" required>
                            <option value="">Select country...</option>
                            @foreach(['Russia', 'Kazakhstan', 'Uzbekistan', 'Kyrgyzstan', 'Tajikistan', 'Turkmenistan', 'Belarus', 'Ukraine', 'Georgia', 'Armenia', 'Azerbaijan', 'Moldova', 'United States', 'United Kingdom', 'Germany', 'France', 'Canada', 'Australia', 'Japan', 'South Korea', 'China', 'Turkey', 'Israel', 'UAE'] as $country)
                            <option value="{{ $country }}" {{ old('customer_country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                        @error('customer_country')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">City <span class="text-primary">*</span></label>
                        <input type="text" name="customer_city" value="{{ old('customer_city') }}" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm" required placeholder="e.g. Moscow">
                        @error('customer_city')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Full Address <span class="text-primary">*</span></label>
                    <textarea name="customer_address" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm resize-none" rows="3" required placeholder="Street address, apartment number, postal code...">{{ old('customer_address') }}</textarea>
                    @error('customer_address')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-foreground mb-2">Order Notes <span class="text-muted-foreground font-normal">(Optional)</span></label>
                    <textarea name="notes" class="w-full px-4 py-3 bg-muted border border-border rounded-xl text-foreground placeholder:text-muted-foreground/50 focus:outline-none focus:border-primary transition-colors text-sm resize-none" rows="2" placeholder="Special requests, gift message...">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Submit --}}
            <div class="bg-card border border-border p-6 rounded-2xl">
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-foreground">How it works</p>
                        <p class="text-xs text-muted-foreground mt-0.5">After submitting, we'll confirm your order via email within 24 hours with payment details via Telegram or WhatsApp.</p>
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

            {{-- Trust --}}
            <div class="grid grid-cols-3 gap-4">
                @foreach([
                    ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'label' => 'Email confirmation'],
                    ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Gift case included'],
                    ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Worldwide shipping'],
                ] as $trust)
                <div class="text-center">
                    <div class="w-8 h-8 mx-auto mb-2 rounded-lg bg-primary/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $trust['icon'] }}"/></svg>
                    </div>
                    <p class="text-[11px] text-muted-foreground leading-tight">{{ $trust['label'] }}</p>
                </div>
                @endforeach
            </div>
        </form>

    </div>
</section>

@endsection
