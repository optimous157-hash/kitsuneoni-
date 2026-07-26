<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find products array boundaries
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start);
$productsArea = substr($c, $start, $end - $start + 2);
$after = substr($c, $end + 2);

// Fix the Kitsuneoni Admin mistake first - revert it
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$c = str_replace("'short_description' => 'Kitsuneoni Admin. Hand-forged, full tang. Ready to go.'", "'short_description' => null", $c);
file_put_contents('database/seeders/DatabaseSeeder.php', $c);

// Re-read
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12); // include '$products = ['
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end);

// Split into individual product blocks
$blocks = preg_split('/\],\s*\n\s*(?=\[)/', $productsArea);
echo "Found " . count($blocks) . " product blocks\n";

$shortTemplates = [
    function($name) { return "$name. Hand-forged, full tang. Ready to go."; },
    function($name) { return "$name — forged from quality steel, balanced, and built to last."; },
    function($name) { return "Full-tang $name. Hand-forged and polished. Comes with display stand and gift box."; },
    function($name) { return "A collector's $name. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($name) { return "$name. Forged by hand. Full tang. Ready for display."; },
    function($name) { return "Full-tang $name, forged by hand. Includes stand, case, and oil."; },
];

$newBlocks = [];
$idx = 0;
$nameFix = "@@NAME@@"; // placeholder

foreach ($blocks as $block) {
    // Extract name
    if (preg_match("/'name'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/", $block, $nm)) {
        $name = stripslashes($nm[1]);
    } else {
        $newBlocks[] = $block;
        continue;
    }
    
    // Extract specs
    $steel = '';
    $length = '';
    $handle = '';
    $hardness = '';
    if (preg_match("/'steel_type'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/", $block, $sm)) $steel = stripslashes($sm[1]);
    if (preg_match("/'overall_length'\s*=>\s*([\d.]+)/", $block, $lm)) $length = $lm[1];
    if (preg_match("/'handle_material'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/", $block, $hm)) $handle = stripslashes($hm[1]);
    if (preg_match("/'hardness_hrc'\s*=>\s*(\d+)/", $block, $hrm)) $hardness = $hrm[1];
    
    $tplIdx = $idx % count($shortTemplates);
    $newShort = $shortTemplates[$tplIdx]($name);
    
    $isTanto = $length && (float)$length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    
    $descParts = [];
    $descParts[] = "<p>The $name is a full-tang $type forged from $steel.";
    if ($hardness) $descParts[] = " Hardened to ~{$hardness}HRC.";
    $descParts[] = " The handle uses $handle.</p>";
    $descParts[] = "<p>It comes with a display stand, a gift case, and maintenance oil. Ready to display right out of the box.</p>";
    $newDesc = implode('', $descParts);
    
    // Escape for PHP string
    $newShortEsc = str_replace("'", "\\'", $newShort);
    $newDescEsc = str_replace("'", "\\'", $newDesc);
    
    // Replace short_description
    $block = preg_replace("/'short_description'\s*=>\s*'[^']*'/", "'short_description' => '$newShortEsc'", $block);
    
    // Replace description (first long string after 'description')
    $block = preg_replace("/'description'\s*=>\s*'[^']*'/", "'description' => '$newDescEsc'", $block);
    
    $newBlocks[] = $block;
    $idx++;
}

$newProductsArea = implode("],\n    ", $newBlocks);
$newContent = $before . $newProductsArea . $after;

file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);

// Verify
$v = file_get_contents('database/seeders/DatabaseSeeder.php');
preg_match_all("/'price'\s*=>\s*(\d+)/", $v, $prices);
echo "Total products with prices: " . count($prices[1]) . "\n";
echo "Sample new descriptions:\n";
for ($i = 0; $i < min(3, count($newBlocks)); $i++) {
    if (preg_match("/'short_description'\s*=>\s*'([^']+)'/", $newBlocks[$i], $sm)) {
        echo "  " . $sm[1] . "\n";
    }
}
