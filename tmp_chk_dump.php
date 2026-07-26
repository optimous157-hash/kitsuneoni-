<?php
$dump = file_get_contents('kitsuneoni_dump.sql');
$start = strpos($dump, "INSERT INTO `products`");
$end = strpos($dump, ";", $start);
$insert = substr($dump, $start, $end - $start + 1);

// Extract first product values
if (preg_match("/VALUES\s*\((.*?)\)/s", $insert, $m)) {
    echo "First 300 chars of values:\n" . substr($m[1], 0, 300) . "\n";
}

// Count products
$count = preg_match_all("/\),\s*\(/s", $insert);
echo "Products in dump: " . ($count + 1) . "\n";

// Check first product description
preg_match("/VALUES\s*\([^)]+/s", $insert, $m1);
echo "\nFirst product snippet:\n" . substr($m1[0], 0, 500) . "\n";
