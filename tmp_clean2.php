<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end + 2);

$blocks = preg_split('/\],\s*\n\s*(?=\[)/', $productsArea);
$blocks[0] = ltrim($blocks[0]);

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A custom $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

function findStringEnd($str, $pos) {
    $i = $pos + 1;
    while ($i < strlen($str)) {
        if ($str[$i] === '\\') {
            $i += 2;
            continue;
        }
        if ($str[$i] === "'") {
            return $i;
        }
        $i++;
    }
    return false;
}

function cleanupOrphanedText($block, $afterPos) {
    // After position $afterPos in $block, remove everything up to the next field name
    // Field names are like: 'name' =>, 'slug' =>, 'price' =>, 'sku' =>, etc.
    // Or the end of block: ],
    $rest = substr($block, $afterPos);
    // Find the next field or end of block
    if (preg_match("/\n\s+'[a-z_]+'\s*=>/s", $rest, $m, PREG_OFFSET_CAPTURE)) {
        // There's a next field
        $nextFieldPos = $m[0][1];
        return substr($block, 0, $afterPos) . substr($rest, $nextFieldPos);
    } else {
        // No next field found - maybe end of block
        // Look for ], which marks end of product entry
        $eob = strpos($rest, '],');
        if ($eob !== false) {
            return substr($block, 0, $afterPos) . substr($rest, $eob);
        }
        // Otherwise just return as is
        return $block;
    }
}

$idx = 0;
foreach ($blocks as &$block) {
    $name = $steel = $length = $handle = $hardness = '';
    
    $np = strpos($block, "'name' => '");
    if ($np !== false) {
        $ne = findStringEnd($block, $np + strlen("'name' => "));
        if ($ne !== false) $name = str_replace("\\'", "'", substr($block, $np + strlen("'name' => '"), $ne - $np - strlen("'name' => '")));
    }
    
    $sp = strpos($block, "'steel_type' => '");
    if ($sp !== false) {
        $se = findStringEnd($block, $sp + strlen("'steel_type' => "));
        if ($se !== false) $steel = str_replace("\\'", "'", substr($block, $sp + strlen("'steel_type' => '"), $se - $sp - strlen("'steel_type' => '")));
    }
    
    $lp = strpos($block, "'overall_length' => ");
    if ($lp !== false) {
        $ls = $lp + strlen("'overall_length' => ");
        $le = strpos($block, ",", $ls);
        if ($le !== false) $length = trim(substr($block, $ls, $le - $ls));
    }
    
    $hp = strpos($block, "'handle_material' => '");
    if ($hp !== false) {
        $he = findStringEnd($block, $hp + strlen("'handle_material' => "));
        if ($he !== false) $handle = str_replace("\\'", "'", substr($block, $hp + strlen("'handle_material' => '"), $he - $hp - strlen("'handle_material' => '")));
    }
    
    $hrp = strpos($block, "'hardness_hrc' => ");
    if ($hrp !== false) {
        $hrs = $hrp + strlen("'hardness_hrc' => ");
        $hre = strpos($block, ",", $hrs);
        if ($hre !== false) $hardness = trim(substr($block, $hrs, $hre - $hrs));
    }
    
    // Generate new short description
    $newShort = $shortTemplates[$idx % count($shortTemplates)]($name);
    
    // Replace short_description
    $sdLabel = "'short_description' => '";
    $sdPos = strpos($block, $sdLabel);
    if ($sdPos !== false) {
        $sdEnd = findStringEnd($block, $sdPos + strlen($sdLabel) - 1);
        if ($sdEnd !== false) {
            $block = substr_replace($block, "'short_description' => '$newShort'", $sdPos, $sdEnd - $sdPos + 1);
            // Cleanup orphaned text after the new short_description
            $newSdEnd = $sdPos + strlen("'short_description' => '$newShort'");
            $block = cleanupOrphanedText($block, $newSdEnd);
        }
    }
    
    // Generate new description
    $isTanto = $length !== '' && (float)$length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $hrc = $hardness ? " Hardened to ~{$hardness}HRC." : '';
    $newDesc = "<p>The $name is a full-tang $type made from $steel.{$hrc} The handle uses $handle.</p><p>Comes with a display stand, gift case, and oil.</p>";
    
    // Replace description
    $dLabel = "'description' => '";
    $dPos = strpos($block, $dLabel);
    if ($dPos !== false) {
        $dEnd = findStringEnd($block, $dPos + strlen($dLabel) - 1);
        if ($dEnd !== false) {
            $block = substr_replace($block, "'description' => '$newDesc'", $dPos, $dEnd - $dPos + 1);
            // Cleanup orphaned text after the new description
            $newDEnd = $dPos + strlen("'description' => '$newDesc'");
            $block = cleanupOrphanedText($block, $newDEnd);
        }
    }
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
file_put_contents('database/seeders/DatabaseSeeder.php', $before . $newProductsArea . $after);

passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");

$v = file_get_contents('database/seeders/DatabaseSeeder.php');
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible', "'s Dragonfly"];
foreach ($checks as $chk) {
    echo str_contains($v, $chk) ? "STILL HAS: $chk\n" : "CLEAN: $chk\n";
}
echo "Prices: " . preg_match_all("/'price'\s*=>\s*\d+/", $v) . "\n";

// Show a few sample descriptions
preg_match_all("/'short_description'\s*=>\s*'([^']+)'/", $v, $samples);
echo "Sample short descriptions:\n";
foreach (array_slice($samples[1], 0, 5) as $s) echo "  $s\n";
