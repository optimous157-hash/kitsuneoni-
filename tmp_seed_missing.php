<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Hardcode the humanized FAQ data
$faqs = [
    [
        'question' => 'How do I place an order?',
        'answer' => 'Click "Order Now" on any product page, fill in your details, and submit. We\'ll confirm via email with payment details.',
        'sort_order' => 1,
        'is_active' => true,
    ],
    [
        'question' => 'How long does shipping take?',
        'answer' => '<strong>CIS countries:</strong> 3-7 business days via CDEK, Russian Post, or Yandex Delivery.<br><strong>International:</strong> 7-21 business days via DHL or UPS.',
        'sort_order' => 2,
        'is_active' => true,
    ],
    [
        'question' => 'Are the products handmade?',
        'answer' => 'Yes! Every piece is handcrafted in our workshop. Slight variations may occur — this confirms authenticity.',
        'sort_order' => 3,
        'is_active' => true,
    ],
    [
        'question' => 'What payment methods do you accept?',
        'answer' => 'We use a manual order system. After placing your order, we\'ll confirm and provide payment options via email.',
        'sort_order' => 4,
        'is_active' => true,
    ],
    [
        'question' => 'Can I track my order?',
        'answer' => 'Yes! Once shipped, you\'ll receive a tracking number via email.',
        'sort_order' => 5,
        'is_active' => true,
    ],
    [
        'question' => 'Do you offer custom pieces?',
        'answer' => 'Absolutely! Contact us via email to discuss custom orders.',
        'sort_order' => 6,
        'is_active' => true,
    ],
    [
        'question' => 'What is included with each order?',
        'answer' => 'The product, a premium gift case, display stand (where applicable), and maintenance oil.',
        'sort_order' => 7,
        'is_active' => true,
    ],
    [
        'question' => 'Do you have a loyalty program?',
        'answer' => 'Yes! Bronze (3% after 1 order), Silver (5% after 3 orders), Gold (10% after 5 orders). Your level is permanent.',
        'sort_order' => 8,
        'is_active' => true,
    ],
];

$settings = [
    ['group' => 'general', 'key' => 'site_name', 'value' => 'Kitsuneoni', 'type' => 'text'],
    ['group' => 'general', 'key' => 'site_tagline', 'value' => 'Premium Handcrafted Japanese Collectibles', 'type' => 'text'],
    ['group' => 'general', 'key' => 'contact_email', 'value' => 'orders@kitsuneoni.com', 'type' => 'text'],
];

// Only seed if tables are empty
if (DB::table('faqs')->count() == 0) {
    foreach ($faqs as $f) {
        DB::table('faqs')->insert($f);
    }
    echo "Seeded " . count($faqs) . " FAQs\n";
} else {
    echo "FAQs already seeded\n";
}

if (DB::table('settings')->count() == 0) {
    foreach ($settings as $s) {
        DB::table('settings')->insert($s);
    }
    echo "Seeded " . count($settings) . " settings\n";
} else {
    echo "Settings already seeded\n";
}

echo "Done.\n";
