<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$rows = DB::table('products')->select('name','slug','stock','in_stock')->orderBy('id')->get();
foreach ($rows as $r) {
    echo str_pad($r->name, 28) . " stock=" . $r->stock . " in_stock=" . ($r->in_stock?1:0) . "\n";
}
echo "COUNT: " . $rows->count() . "\n";
