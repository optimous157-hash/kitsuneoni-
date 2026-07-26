<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbProducts = DB::table('products')->orderBy('id')->get();
if (count($dbProducts) === 0 && file_exists('tmp_products_data.php')) {
    $saved = require 'tmp_products_data.php';
    $dbProducts = collect($saved);
    echo "Loaded " . count($dbProducts) . " products from backup\n";
} else {
    echo "Loaded " . count($dbProducts) . " products from DB\n";
}

// Get the admin user from DB
$admin = DB::table('users')->where('email', 'admin@kitsuneoni.com')->first();

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A custom $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

$productsCode = "\$products = [\n";
$idx = 0;
foreach ($dbProducts as $p) {
    $shortPat = $shortTemplates[$idx % count($shortTemplates)];
    $shortDesc = $shortPat($p->name);
    
    $isTanto = (float)$p->overall_length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $hrc = $p->hardness_hrc ? " Hardened to ~{$p->hardness_hrc}HRC." : '';
    $desc = "<p>The {$p->name} is a full-tang $type made from {$p->steel_type}.{$hrc} The handle uses {$p->handle_material}.</p><p>Comes with a display stand, gift case, and oil.</p>";
    
    $metaTitle = "{$p->name} -- {$p->steel_type} | Kitsuneoni";
    $metaDesc = "{$p->steel_type}, {$p->overall_length}cm, {$p->handle_material} | Kitsuneoni";
    $images = json_decode($p->images ?? '[]', true) ?: [];
    
    $productsCode .= "    [\n";
    $productsCode .= "        'name' => " . var_export($p->name, true) . ",\n";
    $productsCode .= "        'slug' => " . var_export($p->slug, true) . ",\n";
    $productsCode .= "        'short_description' => " . var_export($shortDesc, true) . ",\n";
    $productsCode .= "        'description' => " . var_export($desc, true) . ",\n";
    $productsCode .= "        'price' => " . (int)$p->price . ",\n";
    $productsCode .= "        'sku' => " . var_export($p->sku, true) . ",\n";
    $productsCode .= "        'stock' => " . (int)$p->stock . ",\n";
    $productsCode .= "        'is_featured' => " . ($p->is_featured ? 'true' : 'false') . ",\n";
    $productsCode .= "        'is_bestseller' => " . ($p->is_bestseller ? 'true' : 'false') . ",\n";
    $productsCode .= "        'is_new' => " . ($p->is_new ? 'true' : 'false') . ",\n";
    $productsCode .= "        'category_id' => \$createdCategories[" . ($idx % 5) ."]->id,\n";
    $productsCode .= "        'brand_id' => \$brand->id,\n";
    $productsCode .= "        'material' => " . var_export($p->material ?? $p->steel_type, true) . ",\n";
    $productsCode .= "        'steel_type' => " . var_export($p->steel_type, true) . ",\n";
    $productsCode .= "        'construction' => " . var_export($p->construction ?? 'Full Tang', true) . ",\n";
    $productsCode .= "        'hardness_hrc' => " . ((int)$p->hardness_hrc ?: 'null') . ",\n";
    $productsCode .= "        'overall_length' => " . (float)$p->overall_length . ",\n";
    $productsCode .= "        'blade_length' => " . (float)$p->blade_length . ",\n";
    $productsCode .= "        'blade_width' => " . (float)$p->blade_width . ",\n";
    $productsCode .= "        'blade_thickness' => " . (float)$p->blade_thickness . ",\n";
    $productsCode .= "        'handle_material' => " . var_export($p->handle_material, true) . ",\n";
    $productsCode .= "        'scabbard_material' => " . var_export($p->scabbard_material ?? '', true) . ",\n";
    $productsCode .= "        'weight' => " . ((int)$p->weight ?: 'null') . ",\n";
    $productsCode .= "        'meta_title' => " . var_export($metaTitle, true) . ",\n";
    $productsCode .= "        'meta_description' => " . var_export($metaDesc, true) . ",\n";
    $productsCode .= "        'video_url' => " . var_export($p->video_url ?? '', true) . ",\n";
    $productsCode .= "        'video_file' => " . var_export($p->video_file ?? '', true) . ",\n";
    // $productsCode .= "        'images' => " . var_export($images, true) . ",\n";
    $productsCode .= "        'sales_count' => " . (int)$p->sales_count . ",\n";
    $productsCode .= "    ],\n";
    $idx++;
}
$productsCode .= "];\n";

// Hardcoded FAQs (humanized, no Telegram/WhatsApp)
$faqs = [
    ['question' => 'How do I place an order?', 'answer' => 'Click "Order Now" on any product page, fill in your details, and submit. We will confirm via email with payment details.', 'sort_order' => 1],
    ['question' => 'How long does shipping take?', 'answer' => '<strong>CIS countries:</strong> 3-7 business days via CDEK, Russian Post, or Yandex Delivery.<br><strong>International:</strong> 7-21 business days via DHL or UPS.', 'sort_order' => 2],
    ['question' => 'Are the products handmade?', 'answer' => 'Yes! Every piece is handcrafted in our workshop. Slight variations may occur - this confirms authenticity.', 'sort_order' => 3],
    ['question' => 'What payment methods do you accept?', 'answer' => 'We use a manual order system. After placing your order, we will confirm and provide payment options via email.', 'sort_order' => 4],
    ['question' => 'Can I track my order?', 'answer' => 'Yes! Once shipped, you will receive a tracking number via email.', 'sort_order' => 5],
    ['question' => 'Do you offer custom pieces?', 'answer' => 'Absolutely! Send us an email to discuss custom orders.', 'sort_order' => 6],
    ['question' => 'What is included with each order?', 'answer' => 'The product, a premium gift case, display stand (where applicable), and maintenance oil.', 'sort_order' => 7],
    ['question' => 'Do you have a loyalty program?', 'answer' => 'Yes! Bronze (3% after 1 order), Silver (5% after 3 orders), Gold (10% after 5 orders). Your level is permanent.', 'sort_order' => 8],
];
$faqCode = '';
foreach ($faqs as $f) {
    $faqCode .= "            [\n";
    $faqCode .= "                'question' => " . var_export($f['question'], true) . ",\n";
    $faqCode .= "                'answer' => " . var_export($f['answer'], true) . ",\n";
    $faqCode .= "                'sort_order' => " . $f['sort_order'] . ",\n";
    $faqCode .= "                'is_active' => true,\n";
    $faqCode .= "            ],\n";
}

// Settings
$settings = [
    ['group' => 'general', 'key' => 'site_name', 'value' => 'Kitsuneoni', 'type' => 'text'],
    ['group' => 'general', 'key' => 'site_tagline', 'value' => 'Premium Handcrafted Japanese Collectibles', 'type' => 'text'],
    ['group' => 'general', 'key' => 'contact_email', 'value' => 'orders@kitsuneoni.com', 'type' => 'text'],
];
$settingsCode = '';
foreach ($settings as $s) {
    $settingsCode .= "            [\n";
    $settingsCode .= "                'group' => " . var_export($s['group'], true) . ",\n";
    $settingsCode .= "                'key' => " . var_export($s['key'], true) . ",\n";
    $settingsCode .= "                'value' => " . var_export($s['value'], true) . ",\n";
    $settingsCode .= "                'type' => " . var_export($s['type'], true) . ",\n";
    $settingsCode .= "            ],\n";
}

// Product images - generate from the product list schema
$piCode = '';
// Auto-generate product images based on product names
$idx = 0;
foreach ($dbProducts as $p) {
    $slug = $p->slug;
    for ($imgIdx = 1; $imgIdx <= 9; $imgIdx++) {
        $piCode .= "            [\n";
        $piCode .= "                'product_id' => " . ($idx + 1) . ",\n";
        $piCode .= "                'path' => " . var_export("products/{$slug}-{$imgIdx}.jpg", true) . ",\n";
        $piCode .= "                'alt_text' => " . var_export($p->name, true) . ",\n";
        $piCode .= "                'is_primary' => " . ($imgIdx === 1 ? 'true' : 'false') . ",\n";
        $piCode .= "                'sort_order' => " . ($imgIdx - 1) . ",\n";
        $piCode .= "            ],\n";
    }
    $idx++;
}

// Build the entire file
$content = <<<'PHPHEADER'
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\Faq;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clean existing records
        ProductImage::truncate();
        Product::truncate();
        Brand::truncate();
        Category::truncate();
        User::truncate();

        // Create admin user
        $admin = User::create([
            'name' => 'Kitsuneoni Admin',
            'email' => 'admin@kitsuneoni.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);
        $admin->markEmailAsVerified();

        // Create categories
        $createdCategories = [];
        foreach ([
            ['name' => 'Katanas', 'slug' => 'katanas', 'description' => 'Premium handcrafted Japanese katanas'],
            ['name' => 'Wakizashi', 'slug' => 'wakizashi', 'description' => 'Short Japanese swords'],
            ['name' => 'Tanto', 'slug' => 'tanto', 'description' => 'Japanese short blades'],
            ['name' => 'Display Stands', 'slug' => 'display-stands', 'description' => 'Premium display stands for your collection'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Maintenance oil, cases, and more'],
        ] as $cat) {
            $createdCategories[] = Category::create($cat);
        }

        $brand = Brand::create([
            'name' => 'Kitsuneoni',
            'slug' => 'kitsuneoni',
            'description' => "Kitsuneoni Workshop — Author's workshop specializing in handcrafted Japanese collectibles.",
            'is_active' => true,
        ]);

        // ════════════════════════════════════════════════════════════════
        //  PRODUCTS
        // ════════════════════════════════════════════════════════════════

PHPHEADER;

$content .= $productsCode;
$content .= "\n";
$content .= "        foreach (\$products as \$productData) {\n";
$content .= "            Product::create(\$productData);\n";
$content .= "        }\n\n";

// Product images
$content .= <<<'PIMID'
        // ════════════════════════════════════════════════════════════════
        //  PRODUCT IMAGES
        // ════════════════════════════════════════════════════════════════

PIMID;

$content .= "        \$productImages = [\n";
$content .= $piCode;
$content .= "        ];\n\n";

// Seed product images
$content .= <<<'SEEDPI'
        foreach ($productImages as $pi) {
            ProductImage::create($pi);
        }

SEEDPI;

// Settings
$content .= <<<'SETS'

        // ════════════════════════════════════════════════════════════════
        //  SETTINGS
        // ════════════════════════════════════════════════════════════════

        $settings = [
SETS;
$content .= $settingsCode;
$content .= "        ];\n\n";
$content .= <<<'SEEDSET'
        foreach ($settings as $s) {
            Setting::create($s);
        }

SEEDSET;

// FAQs
$content .= <<<'FAQS'

        // ════════════════════════════════════════════════════════════════
        //  FAQS
        // ════════════════════════════════════════════════════════════════

        $faqs = [
FAQS;
$content .= $faqCode;
$content .= "        ];\n\n";
$content .= <<<'SEEDFAQ'
        foreach ($faqs as $f) {
            Faq::create($f);
        }

SEEDFAQ;

// Update products with images
$content .= <<<'UPDATEPI'

        // ════════════════════════════════════════════════════════════════
        //  INCREMENT SEQUENCES
        // ════════════════════════════════════════════════════════════════

        // Get the max ID for each relevant table to sync sequences
        if (config('database.default') === 'pgsql') {
            $tables = ['users', 'categories', 'brands', 'products', 'product_images', 'settings', 'faqs'];
            foreach ($tables as $table) {
                $max = \DB::table($table)->max('id');
                if ($max) {
                    \DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), {$max})");
                }
            }
        }
    }
}
UPDATEPI;

file_put_contents('database/seeders/DatabaseSeeder.php', $content);
echo "Written complete seeder.\n";
passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");
