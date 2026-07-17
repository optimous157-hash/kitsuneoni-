<x-mail::message>
# Welcome to Kitsuneoni

Thank you for subscribing to our newsletter!

You'll be the first to know about:
- New handcrafted collections
- Exclusive limited editions
- Workshop stories and artisan features
- Special offers and loyalty rewards

Each piece we create tells a story. We're excited to share ours with you.

<x-mail::button :url="route('shop.index')">
Explore Our Collection
</x-mail::button>

Warm regards,<br>
{{ config('app.name') }}
</x-mail::message>
