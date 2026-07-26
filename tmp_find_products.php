<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
echo "File length: " . strlen($c) . "\n";

// Find ALL occurrences of $products = [
$pos = 0;
$count = 0;
while (($pos = strpos($c, '$products = [', $pos)) !== false) {
    $count++;
    $ctx = substr($c, max(0, $pos-50), 80);
    $ctx = preg_replace('/[\x00-\x1f]/', '.', $ctx);
    echo "#$count at $pos: ...$ctx\n";
    $pos++;
}
echo "Total: $count\n";
