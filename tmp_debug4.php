<?php
$ref = file_get_contents('database/seeders/DatabaseSeeder.php');
$lastEnd = strrpos($ref, '];');
echo "Last ]; at: $lastEnd\n";
$afterContent = substr($ref, $lastEnd + 2);
echo "AfterContent length: " . strlen($afterContent) . "\n";
echo "First 100 chars: '" . substr($afterContent, 0, 100) . "'\n";

// Count $products in afterContent
$count = 0;
$pos = 0;
while (($pos = strpos($afterContent, '$products = [', $pos)) !== false) {
    $count++;
    echo "#$count at $pos in afterContent, context: " . substr($afterContent, max(0,$pos-20), 60) . "\n";
    $pos++;
}
echo "Found in afterContent: $count\n";
