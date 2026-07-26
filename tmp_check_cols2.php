<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Settings columns: " . implode(', ', Schema::getColumnListing('settings')) . "\n";
echo "Product images columns: " . implode(', ', Schema::getColumnListing('product_images')) . "\n";
echo "Products columns: " . implode(', ', Schema::getColumnListing('products')) . "\n";

$s = DB::table('settings')->first();
if ($s) print_r($s);

$pi = DB::table('product_images')->first();
if ($pi) print_r($pi);
