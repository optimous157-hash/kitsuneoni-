<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Products: " . DB::table('products')->count() . "\n";
echo "Users: " . DB::table('users')->count() . "\n";
echo "Categories: " . DB::table('categories')->count() . "\n";
echo "Brands: " . DB::table('brands')->count() . "\n";
echo "FAQs: " . DB::table('faqs')->count() . "\n";
echo "Settings: " . DB::table('settings')->count() . "\n";
echo "Product images: " . DB::table('product_images')->count() . "\n";

// Check description of first product
$first = DB::table('products')->orderBy('id')->first();
echo "First: {$first->name} ({$first->price}, {$first->overall_length}cm)\n";
echo "Short: {$first->short_description}\n";
echo "Desc: " . substr($first->description, 0, 120) . "\n";

// Check for actual AI-sounding phrases (not legitimate steel types)
$checks = ['differential clay tempering', 'premium collectible', 'hand-forged from high-carbon'];
$prods = DB::table('products')->get();
$found = false;
foreach ($prods as $p) {
    foreach ($checks as $chk) {
        if (stripos($p->description ?? '', $chk) !== false ||
            stripos($p->short_description ?? '', $chk) !== false ||
            stripos($p->meta_description ?? '', $chk) !== false) {
            echo "AI: {$p->name} has '$chk'\n";
            $found = true;
        }
    }
}
if (!$found) echo "No AI-sounding phrases found\n";
echo "Done\n";
