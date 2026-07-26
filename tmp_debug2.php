<?php
function findStringEnd($str, $pos) {
    $i = $pos + 1;
    while ($i < strlen($str)) {
        if ($str[$i] === '\\') { $i += 2; continue; }
        if ($str[$i] === "'") return $i;
        $i++;
    }
    return false;
}

$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end + 2);

$blocks = preg_split('/\],\s*\n\s*(?=\[)/', $productsArea);
$blocks[0] = ltrim($blocks[0]);

echo "Block 0:\n";
echo substr($blocks[0], 0, 500) . "\n...\n";

// Check description position
$dPos = strpos($blocks[0], "'description' => '");
echo "\nDescription at: $dPos\n";
if ($dPos !== false) {
    $context = substr($blocks[0], $dPos, 200);
    echo "Context: $context\n";
    
    $dEnd = findStringEnd($blocks[0], $dPos + strlen("'description' => ") - 1);
    echo "Desc end at: $dEnd\n";
    echo "Char at desc end: '" . $blocks[0][$dEnd] . "'\n";
    echo "After desc end (20 chars): '" . substr($blocks[0], $dEnd + 1, 20) . "'\n";
}
