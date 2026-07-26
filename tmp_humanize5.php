<?php
// Simple targeted replacement of AI-sounding phrases with natural alternatives
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end);

// Split into product blocks
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

$descTemplates = [
    // Simple, no-escaping-needed descriptions
    function($n, $s, $h, $hr) {
        $len = ''; $hrc = '';
        if ($hr) $hrc = " Hardened to ~{$hr}HRC.";
        $t = ((float)$h < 70) ? 'tanto' : 'blade';
        return "<p>The $n is a full-tang $t made from $s.{$hrc} The handle uses $h.</p><p>Comes with a display stand, gift case, and oil.</p>";
    },
];

$idx = 0;
foreach ($blocks as &$block) {
    // Get the name using simple approach - find text between "=> '" and next "'"
    $np = strpos($block, "'name' => '");
    if ($np === false) { $idx++; continue; }
    $ns = $np + strlen("'name' => '");
    $ne = strpos($block, "'", $ns);
    // Handle escaped quotes in name
    while ($ne !== false && $ne > $ns && $block[$ne-1] === '\\') {
        $ne = strpos($block, "'", $ne + 1);
    }
    if ($ne === false) { $idx++; continue; }
    $name = substr($block, $ns, $ne - $ns);
    $name = str_replace("\\'", "'", $name);
    
    // Extract specs
    $steel = $length = $handle = $hardness = '';
    
    $sp = strpos($block, "'steel_type' => '");
    if ($sp !== false) {
        $ss = $sp + strlen("'steel_type' => '");
        $se = strpos($block, "'", $ss);
        while ($se !== false && $se > $ss && $block[$se-1] === '\\') { $se = strpos($block, "'", $se + 1); }
        if ($se !== false) $steel = substr($block, $ss, $se - $ss);
    }
    
    $lp = strpos($block, "'overall_length' => ");
    if ($lp !== false) {
        $ls = $lp + strlen("'overall_length' => ");
        $le = strpos($block, ",", $ls);
        if ($le !== false) $length = trim(substr($block, $ls, $le - $ls));
    }
    
    $hp = strpos($block, "'handle_material' => '");
    if ($hp !== false) {
        $hs = $hp + strlen("'handle_material' => '");
        $he = strpos($block, "'", $hs);
        while ($he !== false && $he > $hs && $block[$he-1] === '\\') { $he = strpos($block, "'", $he + 1); }
        if ($he !== false) $handle = substr($block, $hs, $he - $hs);
    }
    
    $hrp = strpos($block, "'hardness_hrc' => ");
    if ($hrp !== false) {
        $hrs = $hrp + strlen("'hardness_hrc' => ");
        $hre = strpos($block, ",", $hrs);
        if ($hre !== false) $hardness = trim(substr($block, $hrs, $hre - $hrs));
    }
    
    // Generate new short description
    $newShort = $shortTemplates[$idx % count($shortTemplates)]($name);
    
    // Find and replace short_description value
    $sdLabel = "'short_description' => '";
    $sdPos = strpos($block, $sdLabel);
    if ($sdPos !== false) {
        $valStart = $sdPos + strlen($sdLabel);
        $valEnd = strpos($block, "'", $valStart);
        while ($valEnd !== false && $valEnd > $valStart && $block[$valEnd-1] === '\\') {
            $valEnd = strpos($block, "'", $valEnd + 1);
        }
        if ($valEnd !== false) {
            $block = substr_replace($block, $newShort, $valStart, $valEnd - $valStart);
        }
    }
    
    // Generate new description
    $isTanto = $length !== '' && (float)$length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $hrc = $hardness ? " Hardened to ~{$hardness}HRC." : '';
    $newDesc = "<p>The $name is a full-tang $type made from $steel.{$hrc} The handle uses $handle.</p><p>Comes with a display stand, gift case, and oil.</p>";
    // No special escaping needed since we use no single quotes in the content
    
    // Find and replace description value
    $dLabel = "'description' => '";
    $dPos = strpos($block, $dLabel);
    if ($dPos !== false) {
        $valStart = $dPos + strlen($dLabel);
        $valEnd = $valStart;
        $found = false;
        while ($valEnd < strlen($block)) {
            if ($block[$valEnd] === "'" && ($valEnd === 0 || $block[$valEnd-1] !== '\\')) {
                $found = true;
                break;
            }
            $valEnd++;
        }
        if ($found) {
            $block = substr_replace($block, $newDesc, $valStart, $valEnd - $valStart);
        }
    }
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
file_put_contents('database/seeders/DatabaseSeeder.php', $before . $newProductsArea . $after);

// Verify
$v = file_get_contents('database/seeders/DatabaseSeeder.php');
$checks = ['differential clay tempering', 'multi-layered pattern', 'hand-forged from'];
foreach ($checks as $chk) {
    echo str_contains($v, $chk) ? "STILL HAS: $chk\n" : "REMOVED: $chk\n";
}

preg_match_all("/'short_description'\s*=>\s*'/", $v, $sc);
echo "Short desc count: " . count($sc[0]) . "\n";
preg_match_all("/'price'\s*=>\s*(\d+)/", $v, $pc);
echo "Prices: " . count($pc[1]) . "\n";
