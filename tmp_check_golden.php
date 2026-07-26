<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$p = DB::table('products')->where('name', 'Golden Dragon Tan')->first();
if ($p) {
    echo "Name: {$p->name}\n";
    echo "Short: {$p->short_description}\n";
    echo "Desc: {$p->description}\n";
    echo "Meta: {$p->meta_description}\n";
    
    // Check for AI phrases
    $checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible'];
    foreach ($checks as $chk) {
        $found = false;
        foreach (['short_description', 'description', 'meta_description'] as $field) {
            if (stripos($p->$field ?? '', $chk) !== false) {
                echo "FOUND '$chk' in $field\n";
                $found = true;
            }
        }
        if (!$found) echo "Clean: $chk\n";
    }
} else {
    echo "Product not found\n";
}
