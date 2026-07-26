<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');

// Products array boundaries
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end);

// Split by product entries — each product ends with ], on its own line
// and the next starts with [ on its own line
$blocks = preg_split('/\],\s*\n\s*(?=\[)/', $productsArea);
$blocks[0] = ltrim($blocks[0]);

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A collector's $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

$idx = 0;
foreach ($blocks as &$block) {
    // Extract name
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
    
    // Find 'short_description' => '...' and replace
    $sdPos = strpos($block, "'short_description' => '");
    if ($sdPos !== false) {
        $sdStart = $sdPos + strlen("'short_description' => '");
        $sdEnd = strpos($block, "'", $sdStart);
        // Handle escaped quotes
        while ($sdEnd !== false && $sdEnd > 0 && $block[$sdEnd - 1] === '\\') {
            $sdEnd = strpos($block, "'", $sdEnd + 1);
        }
        if ($sdEnd !== false) {
            $block = substr_replace($block, $newShort, $sdStart, $sdEnd - $sdStart);
        }
    }
    
    // New description
    $isTanto = $length && (float)$length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $newDesc = "<p>The $name is a full-tang $type forged from $steel.";
    if ($hardness) $newDesc .= " Hardened to ~{$hardness}HRC.";
    $newDesc .= " The handle uses $handle.</p><p>It comes with a display stand, a gift case, and maintenance oil. Ready to display right out of the box.</p>";
    
    // Escape single quotes for PHP
    $newDesc = str_replace("'", "\\'", $newDesc);
    
    // Find and replace 'description' => '...'
    $dPos = strpos($block, "'description' => '");
    if ($dPos !== false) {
        $dStart = $dPos + strlen("'description' => '");
        // Find the end - the next unescaped single quote followed by comma or newline
        $dEnd = $dStart;
        $depth = 0;
        while ($dEnd < strlen($block)) {
            if ($block[$dEnd] === "'" && ($dEnd === 0 || $block[$dEnd - 1] !== '\\')) {
                break;
            }
            $dEnd++;
        }
        if ($dEnd < strlen($block)) {
            $block = substr_replace($block, $newDesc, $dStart, $dEnd - $dStart);
        }
    }
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
$newContent = $before . $newProductsArea . $after;

// Double-check admin didn't get corrupted
if (strpos($newContent, "'short_description' => null") === false) {
    // Find the admin user and ensure it has null short_description
    $adminPos = strpos($newContent, "'email' => 'admin@kitsuneoni.com'");
    if ($adminPos !== false) {
        // Find the preceding short_description
        $prevSd = strrpos(substr($newContent, 0, $adminPos), "'short_description'");
        if ($prevSd !== false) {
            $sdEnd = strpos($newContent, ",", $prevSd);
            if ($sdEnd !== false) {
                $newContent = substr_replace($newContent, "'short_description' => null", $prevSd, $sdEnd - $prevSd);
            }
        }
    }
}

file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);

// Verify
$v = file_get_contents('database/seeders/DatabaseSeeder.php');
preg_match_all("/'price'\s*=>\s*(\d+)/", $v, $prices);
echo "Prices: " . count($prices[1]) . "\n";

$checks = ['differential clay tempering', 'multi-layered pattern', 'hand-forged T10'];
foreach ($checks as $chk) {
    echo str_contains($v, $chk) ? "STILL HAS: $chk\n" : "REMOVED: $chk\n";
}

// Count short descriptions
preg_match_all("/'short_description'\s*=>\s*'/", $v, $sm);
echo "Short desc count: " . count($sm[0]) . "\n";

// Show sample
preg_match_all("/'short_description'\s*=>\s*'([^']+)'/", $v, $sds, PREG_SET_ORDER);
echo "Sample:\n";
foreach (array_slice($sds, 0, 3) as $s) {
    echo "  {$s[1]}\n";
}
