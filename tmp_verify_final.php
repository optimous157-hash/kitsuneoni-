<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Verify no AI phrases in the seeder file
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible', "collector's"];
foreach ($checks as $chk) {
    echo str_contains($c, $chk) ? "FOUND: $chk\n" : "OK: $chk not found\n";
}

// Check for orphaned patterns
$orphans = ["'s Dragonfly", "display it.'s", "oil.</p>'s", "hand-forged from high-carbon"];
foreach ($orphans as $o) {
    echo str_contains($c, $o) ? "FOUND: $o\n" : "OK: $o not found\n";
}

// Verify products count
$count = preg_match_all("/'price'\s*=>\s*\d+/", $c);
echo "Products: $count\n";

// Verify file structure
echo "Has namespace: " . (str_contains($c, 'namespace Database\\Seeders') ? 'yes' : 'no') . "\n";
echo "Has class: " . (str_contains($c, 'class DatabaseSeeder') ? 'yes' : 'no') . "\n";
echo "Has run(): " . (str_contains($c, 'function run()') ? 'yes' : 'no') . "\n";
echo "File size: " . strlen($c) . "\n";
echo "Products arrays: " . substr_count($c, '$products = [') . "\n";
