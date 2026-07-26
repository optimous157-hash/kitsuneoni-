<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12); 
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end);

// Split blocks more carefully
$blocks = preg_split('/\],\s*\n\s*(?=\[)/', $productsArea);
echo "Blocks: " . count($blocks) . "\n";

// Handle first block that might start with whitespace
$blocks[0] = ltrim($blocks[0]);

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n \x97 forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A collector\x27s $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

$idx = 0;
foreach ($blocks as &$block) {
    // Extract name using a robust pattern
    if (!preg_match("/'name'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/s", $block, $nm)) {
        $idx++; continue;
    }
    $name = stripslashes($nm[1]);
    
    // Extract specs
    $steel = $length = $handle = $hardness = '';
    if (preg_match("/'steel_type'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/s", $block, $m)) $steel = stripslashes($m[1]);
    if (preg_match("/'overall_length'\s*=>\s*([\d.]+)/s", $block, $m)) $length = $m[1];
    if (preg_match("/'handle_material'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/s", $block, $m)) $handle = stripslashes($m[1]);
    if (preg_match("/'hardness_hrc'\s*=>\s*(\d+)/s", $block, $m)) $hardness = $m[1];
    
    // New short description
    $newShort = $shortTemplates[$idx % count($shortTemplates)]($name);
    $newShortEsc = str_replace(["'", "\\"], ["\\'", "\\\\"], $newShort);
    
    // Replace short_description using a more precise match
    // Match from 'short_description' => ' to the next => or ]
    $block = preg_replace(
        "/'short_description'\s*=>\s*'(?:[^'\\\\]|\\\\.)*'/s",
        "'short_description' => '$newShortEsc'",
        $block,
        1
    );
    
    // Build description
    $isTanto = $length && (float)$length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    
    $descParts = [];
    $descParts[] = "<p>The $name is a full-tang $type forged from $steel.";
    if ($hardness) $descParts[] = " Hardened to ~{$hardness}HRC.";
    $descParts[] = " The handle uses $handle.</p>";
    $descParts[] = "<p>It comes with a display stand, a gift case, and maintenance oil. Ready to display right out of the box.</p>";
    $newDesc = implode('', $descParts);
    
    // Need to escape description for PHP string
    $newDesc = str_replace(["'", "\\"], ["\\'", "\\\\"], $newDesc);
    
    // Replace description field
    $block = preg_replace(
        "/'description'\s*=>\s*'(?:[^'\\\\]|\\\\.)*'/s",
        "'description' => '$newDesc'",
        $block,
        1
    );
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
$newContent = $before . $newProductsArea . $after;

// Verify admin user didn't get corrupted
$newContent = str_replace("'short_description' => 'Kitsuneoni Admin'", "'short_description' => null", $newContent);

file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);

// Verify
$v = file_get_contents('database/seeders/DatabaseSeeder.php');
preg_match_all("/'price'\s*=>\s*(\d+)/", $v, $prices);
echo "Prices: " . count($prices[1]) . "\n";

$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible', 'Hand-forged T10', 'hand-forged from high-carbon'];
foreach ($checks as $chk) {
    echo str_contains($v, $chk) ? "STILL HAS: $chk\n" : "REMOVED: $chk\n";
}

preg_match_all("/'short_description'\s*=>\s*'([^']+)'/", $v, $sm);
echo "Short descriptions: " . count($sm[1]) . "\n";
for ($i = 0; $i < min(5, count($sm[1])); $i++) {
    echo "  $i: {$sm[1][$i]}\n";
}
