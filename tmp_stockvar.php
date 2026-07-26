<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Varied, deterministic stock per product (handcrafted-collectible realism: mostly low-mid, some higher)
$pool = [3, 7, 12, 5, 18, 9, 2, 14, 6, 21, 4, 11, 8, 16, 25, 10, 13, 19, 5, 22, 7, 15, 3, 17, 9, 24, 6, 12, 8, 20, 4, 14, 11, 18, 5, 23, 7, 16, 9, 13, 2, 19, 10, 21, 6, 15, 8, 17];
$rows = DB::table('products')->orderBy('id')->get();
$i = 0;
foreach ($rows as $r) {
    $stock = $pool[$i % count($pool)];
    DB::table('products')->where('id', $r->id)->update([
        'stock' => $stock,
        'in_stock' => $stock > 0 ? 1 : 0,
    ]);
    echo str_pad($r->name, 28) . " -> stock=$stock\n";
    $i++;
}
echo "Updated " . $rows->count() . " products.\n";
