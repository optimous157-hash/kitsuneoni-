@extends('layouts.app')

@section('title', 'FAQ — Kitsuneoni')
@section('description', 'Frequently asked questions about ordering, shipping, products, and payment at Kitsuneoni.')
@section('og_title', 'FAQ — Kitsuneoni')
@section('og_description', 'Frequently asked questions about ordering, shipping, products, and payment at Kitsuneoni.')
@section('page_json_ld')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "name": "FAQ — Kitsuneoni",
    "url": "{{ url()->current() }}",
    "mainEntity": { "@@type": "Organization", "name": "Kitsuneoni" }
}
</script>
@endsection

@section('content')

<script type="application/json" id="faq-data">
{
  "categories": [
    {
      "id": "ordering",
      "label": "Ordering",
      "path": "M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2",
      "items": [
        {
          "id": "o1",
          "q": "How do I place an order?",
          "a": "Click \"Order Now\" on any product page or visit our order page. Fill in your details and submit — we'll confirm via email or Telegram/WhatsApp within 24 hours.",
          "link": {"text": "order page", "url": "/order"}
        },
        {
          "id": "o2",
          "q": "Can I order a custom piece?",
          "a": "Absolutely. Contact us via Telegram @Yamagataaa or WhatsApp with your vision. We'll discuss materials, dimensions, and pricing before starting.",
          "link": {"text": "@Yamagataaa", "url": "https://t.me/Yamagataaa"}
        },
        {
          "id": "o3",
          "q": "What information do I need to provide?",
          "a": "Your full name, email, shipping address, and preferred contact method (Telegram or WhatsApp). For custom orders, include a description or reference images of what you want."
        },
        {
          "id": "o4",
          "q": "Can I modify or cancel my order?",
          "a": "Contact us as soon as possible via Telegram or email. Orders that haven't entered production can be modified or cancelled. Once forging begins, changes may not be possible."
        }
      ]
    },
    {
      "id": "shipping",
      "label": "Shipping",
      "path": "M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
      "items": [
        {
          "id": "s1",
          "q": "How long does shipping take?",
          "a": "Delivery times vary by region: CIS countries 3–7 business days, Europe & Americas 7–21 business days, Australia & Africa 10–25 business days. All shipments via DHL or UPS with full tracking.",
          "table": [
            {"label": "CIS countries", "value": "3–7 business days"},
            {"label": "Europe & Americas", "value": "7–21 business days"},
            {"label": "Australia & Africa", "value": "10–25 business days"}
          ]
        },
        {
          "id": "s2",
          "q": "Do you ship worldwide?",
          "a": "Yes. We ship to over 40 countries worldwide. If your country isn't listed at checkout, contact us via Telegram and we'll arrange delivery."
        },
        {
          "id": "s3",
          "q": "How is my order packaged?",
          "a": "Every piece comes in a premium gift case, securely wrapped for international transit. We use custom-fitted packaging to ensure your collectible arrives in perfect condition."
        },
        {
          "id": "s4",
          "q": "Can I track my order?",
          "a": "Yes. Once shipped, you'll receive a tracking number via email and Telegram/WhatsApp. You can track your package in real-time via the carrier's website."
        },
        {
          "id": "s5",
          "q": "What if my order arrives damaged?",
          "a": "Contact us immediately with photos. We'll arrange a replacement or full refund. All shipments are insured against damage during transit."
        }
      ]
    },
    {
      "id": "products",
      "label": "Products",
      "path": "M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4",
      "items": [
        {
          "id": "p1",
          "q": "Are the products truly handmade?",
          "a": "Yes. Every piece is handcrafted in our workshop. Slight variations in finish and detail are natural and confirm authenticity — no two pieces are exactly alike."
        },
        {
          "id": "p2",
          "q": "What materials do you use?",
          "a": "We use 1045 high-carbon steel for blades, premium hardwoods (oak, zebrawood, ebony) for handles, full-grain vegetable-tanned leather for sheaths, and hand-poured custom epoxy resin for accents.",
          "table": [
            {"label": "Blades", "value": "1045 high-carbon steel"},
            {"label": "Handles", "value": "Oak, zebrawood, ebony"},
            {"label": "Sheaths", "value": "Full-grain vegetable-tanned leather"},
            {"label": "Accents", "value": "Hand-poured custom epoxy resin"}
          ]
        },
        {
          "id": "p3",
          "q": "Are the katanas functional or decorative?",
          "a": "Our katanas are collector-grade pieces. While crafted with traditional techniques and sharp blades, they are intended as collectibles and display pieces. We recommend following local regulations regarding blade ownership."
        },
        {
          "id": "p4",
          "q": "Do you offer a warranty?",
          "a": "We stand behind our craftsmanship. If a product has a manufacturing defect, we'll repair or replace it. Normal wear and damage from misuse are not covered."
        },
        {
          "id": "p5",
          "q": "How should I care for my piece?",
          "a": "Keep blades clean and lightly oiled. Store in the provided case away from humidity. Leather sheaths benefit from occasional conditioning. Detailed care instructions are included with every order."
        }
      ]
    },
    {
      "id": "payment",
      "label": "Payment",
      "path": "M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z",
      "items": [
        {
          "id": "y1",
          "q": "What payment methods do you accept?",
          "a": "We use a manual order system. After placing your order, we'll confirm payment details via Telegram or WhatsApp. We accept bank transfers, PayPal, and cryptocurrency."
        },
        {
          "id": "y2",
          "q": "Do I pay upfront?",
          "a": "For standard orders, full payment is required before production begins. For custom commissions over $500, we offer a 50/50 split — half upfront, half before shipping."
        },
        {
          "id": "y3",
          "q": "Is my payment secure?",
          "a": "All transactions are handled through secure, verified channels. We never store payment details. If you have concerns, we're happy to verify our identity via video call."
        },
        {
          "id": "y4",
          "q": "Do you offer refunds?",
          "a": "If we can't fulfill your order, we offer a full refund. Custom pieces that match the agreed specifications are non-refundable. Damaged-in-transit items are replaced at no cost."
        }
      ]
    }
  ]
}
</script>

<script>
function faqPage() {
  return {
    activeTab: 'ordering',
    openItems: [],
    data: JSON.parse(document.getElementById('faq-data').textContent),

    get currentItems() {
      return this.data.categories.find(c => c.id === this.activeTab).items;
    },

    isOpen(id) {
      return this.openItems.includes(id);
    },

    toggle(id) {
      if (this.isOpen(id)) {
        this.openItems = this.openItems.filter(i => i !== id);
      } else {
        this.openItems.push(id);
      }
    },

    switchTab(id) {
      this.activeTab = id;
      this.openItems = [];
    }
  }
}
</script>

{{-- HERO --}}
<section class="relative py-24 lg:py-32 bg-background overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-background via-primary/5 to-primary/[0.07]"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] opacity-20" style="background: radial-gradient(ellipse at center top, rgba(196,30,58,0.4) 0%, transparent 70%);"></div>
    <div class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 text-center">
        <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Support</span>
        <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-4">Frequently Asked</h1>
        <p class="text-sm text-muted-foreground mt-4 max-w-lg mx-auto leading-relaxed">Everything you need to know about ordering, shipping, and caring for your collectibles.</p>
    </div>
</section>

{{-- FAQ CONTENT --}}
<section class="py-24 lg:py-32 bg-background border-t border-border" x-data="faqPage()">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 max-w-4xl">

        {{-- Category Tabs --}}
        <div class="flex flex-wrap gap-2 mb-12">
            <template x-for="cat in data.categories" :key="cat.id">
                <button @click="switchTab(cat.id)"
                        :class="activeTab === cat.id ? 'bg-primary text-primary-foreground' : 'bg-card text-muted-foreground hover:text-foreground border border-border hover:border-primary/50'"
                        class="flex items-center gap-2.5 px-5 py-2.5 text-[11px] tracking-[0.15em] uppercase font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path :d="cat.path"/>
                    </svg>
                    <span x-text="cat.label"></span>
                </button>
            </template>
        </div>

        {{-- FAQ Accordion --}}
        <div>
            <template x-for="item in currentItems" :key="item.id">
                <div class="border-b border-border">

                    {{-- Question --}}
                    <button @click="toggle(item.id)" class="w-full flex items-center justify-between gap-4 py-5 text-left group">
                        <p class="text-sm font-medium text-foreground leading-snug group-hover:text-primary transition-colors" x-text="item.q"></p>
                        <div class="shrink-0 w-6 h-6 flex items-center justify-center transition-transform duration-200"
                             :class="isOpen(item.id) ? 'rotate-180' : ''">
                            <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>

                    {{-- Answer --}}
                    <div x-show="isOpen(item.id)" x-collapse x-cloak>
                        <div class="pb-5 pt-0">
                            <p class="text-sm text-muted-foreground leading-relaxed" x-text="item.a"></p>

                            {{-- Optional data table --}}
                            <template x-if="item.table">
                                <div class="mt-4 bg-card border border-border overflow-hidden">
                                    <template x-for="(row, idx) in item.table" :key="idx">
                                        <div class="flex items-center justify-between px-5 py-3 text-sm"
                                             :class="idx > 0 ? 'border-t border-border' : ''">
                                            <span class="text-muted-foreground" x-text="row.label"></span>
                                            <span class="font-medium text-foreground" x-text="row.value"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            {{-- Optional inline link --}}
                            <template x-if="item.link">
                                <a :href="item.link.url" class="inline-block mt-3 text-sm font-medium text-primary hover:text-primary/80 transition-colors" x-text="item.link.text + ' →'"></a>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Still Have Questions --}}
        <div class="mt-20 bg-background border border-border relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/5 via-transparent to-primary/5"></div>
            <div class="relative z-10 px-8 py-16 text-center">
                <span class="font-japanese text-5xl text-primary/15 block mb-5">鬼</span>
                <h3 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-3">Still Have Questions?</h3>
                <p class="text-sm text-muted-foreground mb-10 max-w-md mx-auto leading-relaxed">Our team responds within hours. Reach out through any channel — we're ready to help.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="https://t.me/Yamagataaa" target="_blank" rel="noopener" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        Telegram
                    </a>
                    <a href="https://wa.me/YamagataOni" target="_blank" rel="noopener" class="border border-border text-foreground px-8 py-4 text-[11px] tracking-[0.3em] uppercase hover:border-primary hover:text-primary transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    <a href="mailto:yamagataoni@gmail.com" class="border border-border text-foreground px-8 py-4 text-[11px] tracking-[0.3em] uppercase hover:border-primary hover:text-primary transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection