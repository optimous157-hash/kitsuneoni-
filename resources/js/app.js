import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('alpine:init', () => {

    Alpine.store('theme', {
        dark: localStorage.getItem('theme') === 'dark' ||
              (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        },
        init() {
            document.documentElement.classList.toggle('dark', this.dark);
        }
    });

    Alpine.store('cart', {
        items: JSON.parse(localStorage.getItem('cart') || '[]'),
        get count() {
            return this.items.reduce((sum, item) => sum + item.quantity, 0);
        },
        get total() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        add(product, quantity = 1) {
            const existing = this.items.find(i => i.id === product.id);
            if (existing) {
                existing.quantity += quantity;
            } else {
                this.items.push({ ...product, quantity });
            }
            this.save();
        },
        remove(productId) {
            this.items = this.items.filter(i => i.id !== productId);
            this.save();
        },
        updateQuantity(productId, quantity) {
            const item = this.items.find(i => i.id === productId);
            if (item) {
                item.quantity = Math.max(1, quantity);
                this.save();
            }
        },
        clear() {
            this.items = [];
            this.save();
        },
        save() {
            localStorage.setItem('cart', JSON.stringify(this.items));
        }
    });

    Alpine.store('wishlist', {
        items: JSON.parse(localStorage.getItem('wishlist') || '[]'),
        get count() {
            return this.items.length;
        },
        toggle(productId) {
            const index = this.items.indexOf(productId);
            if (index > -1) {
                this.items.splice(index, 1);
            } else {
                this.items.push(productId);
            }
            localStorage.setItem('wishlist', JSON.stringify(this.items));
        },
        has(productId) {
            return this.items.includes(productId);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                entry.target.style.opacity = '1';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-animate]').forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('opacity-0', window.scrollY < 300);
            backToTop.classList.toggle('pointer-events-none', window.scrollY < 300);
        });
    }
});

function formatPrice(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(amount);
}

function formatDate(date) {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(new Date(date));
}
