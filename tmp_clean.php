<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end + 2);

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

// Helper: find the end of a single-quoted PHP string
// $pos is the position of the opening quote
function findStringEnd($str, $pos) {
    $i = $pos + 1;
    while ($i < strlen($str)) {
        if ($str[$i] === '\\') {
            $i += 2; // skip escaped character
            continue;
        }
        if ($str[$i] === "'") {
            return $i;
        }
        $i++;
    }
    return false;
}

$idx = 0;
foreach ($blocks as &$block) {
    // Extract name
    $name = $steel = $length = $handle = $hardness = '';
    
    $np = strpos($block, "'name' => '");
    if ($np !== false) {
        $ne = findStringEnd($block, $np + strlen("'name' => "));
        if ($ne !== false) {
            $name = substr($block, $np + strlen("'name' => '"), $ne - $np - strlen("'name' => '"));
            $name = str_replace("\\'", "'", $name);
        }
    }
    
    $sp = strpos($block, "'steel_type' => '");
    if ($sp !== false) {
        $se = findStringEnd($block, $sp + strlen("'steel_type' => "));
        if ($se !== false) {
            $steel = substr($block, $sp + strlen("'steel_type' => '"), $se - $sp - strlen("'steel_type' => '"));
            $steel = str_replace("\\'", "'", $steel);
        }
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
        if ($he !== false) {
            $handle = substr($block, $hp + strlen("'handle_material' => '"), $he - $hp - strlen("'handle_material' => '"));
            $handle = str_replace("\\'", "'", $handle);
        }
    }
    
    $hrp = strpos($block, "'hardness_hrc' => ");
    if ($hrp !== false) {
        $hrs = $hrp + strlen("'hardness_hrc' => ");
        $hre = strpos($block, ",", $hrs);
        if ($hre !== false) $hardness = trim(substr($block, $hrs, $hre - $hrs));
    }
    
    // Generate new short description (no single quotes in output)
    $newShort = $shortTemplates[$idx % count($shortTemplates)]($name);
    
    // Replace short_description using proper string end finding
    $sdLabel = "'short_description' => '";
    $sdPos = strpos($block, $sdLabel);
    if ($sdPos !== false) {
        $sdEnd = findStringEnd($block, $sdPos + strlen($sdLabel) - 1); // -1 because label includes opening quote
        if ($sdEnd !== false) {
            $oldSd = substr($block, $sdPos, $sdEnd - $sdPos + 1);
            $newSd = "'short_description' => '$newShort'";
            $block = str_replace($oldSd, $newSd, $block);
        }
    }
    
    // Generate new description
    $isTanto = $length !== '' && (float)$length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $hrc = $hardness ? " Hardened to ~{$hardness}HRC." : '';
    $newDesc = "<p>The $name is a full-tang $type made from $steel.{$hrc} The handle uses $handle.</p><p>Comes with a display stand, gift case, and oil.</p>";
    
    // Replace description using proper string end finding
    $dLabel = "'description' => '";
    $dPos = strpos($block, $dLabel);
    if ($dPos !== false) {
        $dEnd = findStringEnd($block, $dPos + strlen($dLabel) - 1);
        if ($dEnd !== false) {
            $oldDesc = substr($block, $dPos, $dEnd - $dPos + 1);
            $newDescBlock = "'description' => '$newDesc'";
            $block = str_replace($oldDesc, $newDescBlock, $block);
        }
    }
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
file_put_contents('database/seeders/DatabaseSeeder.php', $before . $newProductsArea . $after);

passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");

$v = file_get_contents('database/seeders/DatabaseSeeder.php');
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible', 'hand-forged from', "'s Dragonfly", "'s Katana"];
foreach ($checks as $chk) {
    echo str_contains($v, $chk) ? "STILL HAS: $chk\n" : "CLEAN: $chk\n";
}
echo "Prices: " . preg_match_all("/'price'\s*=>\s*\d+/", $v) . "\n";
echo "Short descs: " . preg_match_all("/'short_description'\s*=>\s*'/", $v) . "\n";
