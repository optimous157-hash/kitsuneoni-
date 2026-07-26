<?php

return [
    'name' => env('SITE_NAME', 'Kitsuneoni'),
    'tagline' => env('SITE_TAGLINE', 'Premium Handcrafted Japanese Collectibles'),
    'description' => env('SITE_DESCRIPTION', 'Each piece is handcrafted with precision. Premium Japanese collectibles — katanas, blades, and artisan works. Worldwide shipping.'),
    'url' => env('APP_URL', 'https://kitsuneoni.com'),

    'brand' => [
        'name' => 'Kitsuneoni',
        'subtitle' => '',
        'full' => 'Kitsuneoni',
        'workshop' => 'Kitsuneoni Workshop',
        'description' => 'Author\'s workshop. Metal. Wood. Leather. Resin. Custom collectibles.',
    ],

    'contact' => [
        'email' => env('CONTACT_EMAIL', 'orders@kitsuneoni.com'),
        'telegram' => env('TELEGRAM_URL', 'https://t.me/katana_oni'),
    ],

    'shipping' => [
        'cis' => ['carrier' => 'CDEK / Russian Post / Yandex Delivery', 'min_days' => 3, 'max_days' => 7],
        'international' => ['carrier' => 'DHL / UPS', 'min_days' => 7, 'max_days' => 21],
    ],

    'loyalty' => [
        ['level' => 'Bronze', 'icon' => '🥉', 'purchases' => 1, 'discount' => 3],
        ['level' => 'Silver', 'icon' => '🥈', 'purchases' => 3, 'discount' => 5],
        ['level' => 'Gold', 'icon' => '🥇', 'purchases' => 5, 'discount' => 10],
    ],

    'seo' => [
        'title' => 'Kitsuneoni — Premium Japanese Handcrafted Collectibles',
        'description' => 'Premium handcrafted Japanese collectibles. Each piece forged by hand. Katanas, blades, custom artisan works. Worldwide delivery. Kitsuneoni Workshop.',
        'keywords' => 'japanese katana, handcrafted swords, collectible blades, kitsuneoni, premium japanese, artisan workshop, carbon steel, damascus, Oni like, Katana sword like, Japanese warrior like',
        'og_image' => '/images/og-default.jpg',
    ],

    'analytics' => [
        'google_analytics' => env('GA_TRACKING_ID', ''),
        'google_tag_manager' => env('GTM_ID', ''),
        'yandex_metrika' => env('YANDEX_METRIKA_ID', ''),
    ],
];
