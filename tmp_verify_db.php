<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = DB::table('products')->count();
echo "Products: $products\n";
$users = DB::table('users')->count();
echo "Users: $users\n";
$cats = DB::table('categories')->count();
echo "Categories: $cats\n";
$brands = DB::table('brands')->count();
echo "Brands: $brands\n";
$faqs = DB::table('faqs')->count();
echo "FAQs: $faqs\n";
$settings = DB::table('settings')->count();
echo "Settings: $settings\n";
$images = DB::table('product_images')->count();
echo "Product images: $images\n";

// Verify no AI phrases
$prods = DB::table('products')->get();
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible'];
foreach ($prods as $p) {
    foreach ($checks as $chk) {
        if (stripos($p->description, $chk) !== false || stripos($p->short_description, $chk) !== false || stripos($p->meta_description, $chk) !== false) {
            echo "AI: {$p->name} has '$chk'\n";
        }
    }
}
echo "AI check done.\n";

// Show first and last product
$first = DB::table('products')->orderBy('id')->first();
$last = DB::table('products')->orderBy('id', 'desc')->first();
echo "First: {$first->name} (\${$first->price}, {$first->overall_length}cm)\n";
echo "Last: {$last->name} (\${$last->price}, {$last->overall_length}cm)\n";
echo "Short: {$last->short_description}\n";
