<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = DB::table('products')->orderBy('id')->get();

// Check for AI-sounding phrases across all descriptions
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible', 'hand-forged from high-carbon'];
foreach ($products as $p) {
    $desc = $p->description ?? '';
    $sd = $p->short_description ?? '';
    foreach ($checks as $chk) {
        if (stripos($desc, $chk) !== false || stripos($sd, $chk) !== false) {
            echo "AI phrase '$chk' found in: {$p->name}\n";
        }
    }
}
echo "Check complete.\n";

// Also check for orphaned 's patterns
foreach ($products as $p) {
    $desc = $p->description ?? '';
    $sd = $p->short_description ?? '';
    if (str_contains($desc, "'s") || str_contains($sd, "'s")) {
        // Only flag if it looks like a leftover (display it.'s type pattern)
        if (preg_match("/[a-z]\.'s/", $desc) || preg_match("/[a-z]\.'s/", $sd)) {
            echo "Possible orphan in: {$p->name}\n";
        }
    }
}
echo "Orphan check complete.\n";
