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

$first = DB::table('products')->orderBy('id')->first();
if ($first) {
    echo "First: {$first->name} (\${$first->price}, {$first->overall_length}cm)\n";
    echo "Short: {$first->short_description}\n";
    echo "Desc: " . substr($first->description, 0, 100) . "\n";
}

$last = DB::table('products')->orderBy('id', 'desc')->first();
if ($last) {
    echo "Last: {$last->name} (\${$last->price}, {$last->overall_length}cm)\n";
}

// Check for AI phrases
$prods = DB::table('products')->get();
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible'];
foreach ($prods as $p) {
    foreach ($checks as $chk) {
        if (stripos($p->description ?? '', $chk) !== false || 
            stripos($p->short_description ?? '', $chk) !== false) {
            echo "AI: {$p->name} has '$chk'\n";
        }
    }
}
echo "Done.\n";
