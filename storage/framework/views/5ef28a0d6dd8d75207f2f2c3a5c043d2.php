<?php $__env->startSection('title', 'FAQ — Kitsuneoni'); ?>
<?php $__env->startSection('description', 'Frequently asked questions about ordering, shipping, products, and payment at Kitsuneoni.'); ?>
<?php $__env->startSection('og_title', 'FAQ — Kitsuneoni'); ?>
<?php $__env->startSection('og_description', 'Frequently asked questions about ordering, shipping, products, and payment at Kitsuneoni.'); ?>
<?php $__env->startSection('page_json_ld'); ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "name": "FAQ — Kitsuneoni",
    "url": "<?php echo e(url()->current()); ?>",
    "mainEntity": { "@type": "Organization", "name": "Kitsuneoni" }
}
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

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
          "a": "Hit \"Order Now\" on any product page, fill out the form, and we'll get back to you within 24 hours. That's it.",
          "link": {"text": "order page", "url": "/order"}
        },
        {
          "id": "o2",
          "q": "Can I order a custom piece?",
          "a": "Sure. Shoot us an email with what you have in mind — materials, style, size. We'll figure out the rest together.",
          "link": {"text": "orders@kitsuneoni.com", "url": "mailto:orders@kitsuneoni.com"}
        },
        {
          "id": "o3",
          "q": "What information do I need to provide?",
          "a": "Name, email, shipping address. If it's a custom piece, tell us what you want and send reference pics if you have them."
        },
        {
          "id": "o4",
          "q": "Can I modify or cancel my order?",
          "a": "Email us right away. If we haven't started on it yet, we can change or cancel it. Once the steel hits the anvil, it's locked in."
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
          "a": "Depends where you are. CIS: 3-7 days. Europe & Americas: 7-21 days. Australia & Africa: 10-25 days. All tracked via DHL or UPS.",
          "table": [
            {"label": "CIS countries", "value": "3–7 business days"},
            {"label": "Europe & Americas", "value": "7–21 business days"},
            {"label": "Australia & Africa", "value": "10–25 business days"}
          ]
        },
        {
          "id": "s2",
          "q": "Do you ship worldwide?",
          "a": "Yeah, we ship to about 40 countries. If yours isn't on the list, email us and we'll figure it out."
        },
        {
          "id": "s3",
          "q": "How is my order packaged?",
          "a": "Comes in a gift case, wrapped tight. We pack it like we'd want to receive it."
        },
        {
          "id": "s4",
          "q": "Can I track my order?",
          "a": "Yep. Once it's shipped, we email you the tracking number. You can follow it the whole way."
        },
        {
          "id": "s5",
          "q": "What if my order arrives damaged?",
          "a": "Send us photos right away. We'll replace it or refund you. Everything's insured, so no worries."
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
          "a": "Yes, every piece is made by hand in our workshop. That means no two are identical — the small variations are how you know it's real."
        },
        {
          "id": "p2",
          "q": "What materials do you use?",
          "a": "1045 high-carbon steel for the blade. Oak, zebrawood, or ebony for the handle. Vegetable-tanned leather for the sheath. Hand-poured epoxy for accents.",
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
          "a": "They're made with real steel and real techniques, but they're collectibles — not weapons. Check your local laws before ordering."
        },
        {
          "id": "p4",
          "q": "Do you offer a warranty?",
          "a": "If it's our fault, we'll fix it or replace it. Normal wear and tear or misuse — that's on you."
        },
        {
          "id": "p5",
          "q": "How should I care for my piece?",
          "a": "Keep it clean, keep it oiled, store it in the case. Leather sheath? Condition it now and then. Full instructions come with your order."
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
          "a": "We do things manually. After you order, we email you the payment info. Bank transfer, PayPal, crypto — whatever works."
        },
        {
          "id": "y2",
          "q": "Do I pay upfront?",
          "a": "For standard orders, full payment is required before packaging begins. For custom commissions over $500, we offer a 50/50 split — half upfront, half before shipping."
        },
        {
          "id": "y3",
          "q": "Is my payment secure?",
          "a": "We use trusted payment channels and don't store your card details. If you're unsure, we can hop on a video call to verify."
        },
        {
          "id": "y4",
          "q": "Do you offer refunds?",
          "a": "If we can't deliver, you get your money back. Custom pieces made to your specs can't be refunded. If it arrives damaged, we replace it free."
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


<section class="relative py-16 md:py-24 lg:py-32 bg-background overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-background via-primary/5 to-primary/[0.07]"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] opacity-20" style="background: radial-gradient(ellipse at center top, rgba(196,30,58,0.4) 0%, transparent 70%);"></div>
    <div class="relative z-10 max-w-[1440px] mx-auto px-6 lg:px-12 text-center">
        <span class="text-[11px] tracking-[0.4em] uppercase text-primary mb-4 block">Support</span>
        <h1 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-4">Frequently Asked</h1>
        <p class="text-sm text-muted-foreground mt-4 max-w-lg mx-auto leading-relaxed">Everything you need to know about ordering, shipping, and caring for your collectibles.</p>
    </div>
</section>


<section class="py-16 md:py-24 lg:py-32 bg-background border-t border-border" x-data="faqPage()">
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 max-w-4xl">

        
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

        
        <div>
            <template x-for="item in currentItems" :key="item.id">
                <div class="border-b border-border">

                    
                    <button @click="toggle(item.id)" class="w-full flex items-center justify-between gap-4 py-5 text-left group">
                        <p class="text-sm font-medium text-foreground leading-snug group-hover:text-primary transition-colors" x-text="item.q"></p>
                        <div class="shrink-0 w-6 h-6 flex items-center justify-center transition-transform duration-200"
                             :class="isOpen(item.id) ? 'rotate-180' : ''">
                            <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>

                    
                    <div x-show="isOpen(item.id)" x-collapse x-cloak>
                        <div class="pb-5 pt-0">
                            <p class="text-sm text-muted-foreground leading-relaxed" x-text="item.a"></p>

                            
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

                            
                            <template x-if="item.link">
                                <a :href="item.link.url" class="inline-block mt-3 text-sm font-medium text-primary hover:text-primary/80 transition-colors" x-text="item.link.text + ' →'"></a>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        
        <div class="mt-20 bg-background border border-border relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/5 via-transparent to-primary/5"></div>
            <div class="relative z-10 px-8 py-16 text-center">
                <span class="font-japanese text-5xl text-primary/15 block mb-5">鬼</span>
                <h3 class="font-heading text-4xl lg:text-5xl font-light text-foreground mb-3">Still Have Questions?</h3>
                <p class="text-sm text-muted-foreground mb-10 max-w-md mx-auto leading-relaxed">We usually reply within a few hours. Drop us a message and we'll get back to you.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="mailto:<?php echo e(config('site.contact.email')); ?>" class="bg-[#c41e3a] text-white px-8 py-4 text-[11px] tracking-[0.3em] uppercase font-semibold rounded-xl shadow-[0_0_20px_rgba(196,30,58,0.25)] hover:bg-[#9b1830] hover:shadow-[0_0_35px_rgba(196,30,58,0.4)] hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\OPTIMOUS\OneDrive\Documents\yamagata\yamagata-oni\resources\views\shop\faq.blade.php ENDPATH**/ ?>