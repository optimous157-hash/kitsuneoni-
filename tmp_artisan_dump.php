<?php
// Bootstrap Laravel to access DB and dump products
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = DB::table('products')->orderBy('id')->get();
echo "Total: " . count($products) . "\n";
file_put_contents('tmp_products_data.php', '<?php return ' . var_export($products->toArray(), true) . ';');
echo "Saved products data\n";

// Show first product
if (count($products) > 0) {
    $p = $products[0];
    echo "First: {$p->name} ({$p->steel_type}, {$p->overall_length}cm, {$p->handle_material}, {$p->hardness_hrc}HRC)\n";
}
