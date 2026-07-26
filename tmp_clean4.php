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

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A custom $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

$idx = 0;
foreach ($blocks as &$block) {
    $name = $steel = $length = $handle = $hardness = '';
    
    $np = strpos($block, "'name' => '");
    if ($np !== false) {
        $ne = findStringEnd($block, $np + strlen("'name' => '") - 1);
        if ($ne !== false) $name = str_replace("\\'", "'", substr($block, $np + strlen("'name' => '"), $ne - $np - strlen("'name' => '")));
    }
    
    $sp = strpos($block, "'steel_type' => '");
    if ($sp !== false) {
        $se = findStringEnd($block, $sp + strlen("'steel_type' => '") - 1);
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
        $he = findStringEnd($block, $hp + strlen("'handle_material' => '") - 1);
        if ($he !== false) $handle = str_replace("\\'", "'", substr($block, $hp + strlen("'handle_material' => '"), $he - $hp - strlen("'handle_material' => '")));
    }
    
    $hrp = strpos($block, "'hardness_hrc' => ");
    if ($hrp !== false) {
        $hrs = $hrp + strlen("'hardness_hrc' => ");
        $hre = strpos($block, ",", $hrs);
        if ($hre !== false) $hardness = trim(substr($block, $hrs, $hre - $hrs));
    }
    
    $newShort = $shortTemplates[$idx % count($shortTemplates)]($name);
    
    // Replace short_description (skip if null)
    $sdLabel = "'short_description' => '";
    $sdPos = strpos($block, $sdLabel);
    if ($sdPos !== false) {
        $sdEnd = findStringEnd($block, $sdPos + strlen($sdLabel) - 1);
        if ($sdEnd !== false) {
            // Replace just the value between quotes
            $valStart = $sdPos + strlen($sdLabel); // start quoting quote
            $block = substr_replace($block, $newShort, $valStart, $sdEnd - $valStart);
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
            // Replace just the value between quotes
            $valStart = $dPos + strlen($dLabel);
            $block = substr_replace($block, $newDesc, $valStart, $dEnd - $valStart);
        }
    }
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
file_put_contents('database/seeders/DatabaseSeeder.php', $before . $newProductsArea . $after);

passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");

$v = file_get_contents('database/seeders/DatabaseSeeder.php');
echo "Parse: " . ((strpos(`php -l database/seeders/DatabaseSeeder.php 2>&1`, 'Parse error') === false) ? "OK" : "ERROR") . "\n";

// Check for orphaned text patterns
$bad = ["display it.'s", "oil.</p>'s"];
$allClean = true;
foreach ($bad as $b) {
    if (str_contains($v, $b)) { echo "BAD: $b\n"; $allClean = false; }
}
echo $allClean ? "No orphaned text\n" : "";

echo "Prices: " . preg_match_all("/'price'\s*=>\s*\d+/", $v) . "\n";
