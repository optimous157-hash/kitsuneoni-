<?php
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
echo "Initial meta_description count: " . substr_count($c, "'meta_description' => '") . "\n";

// Replace AI-sounding meta_descriptions
// Find each meta_description and generate a natural one
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start + 12);
$productsArea = substr($c, $start + 12, $end - $start - 12);
$after = substr($c, $end);

$blocks = preg_split('/\],\s*\n\s*(?=\[)/', $productsArea);
$blocks[0] = ltrim($blocks[0]);

$idx = 0;
foreach ($blocks as &$block) {
    // Extract name, steel, length, handle, hardness
    $name = $steel = $length = $handle = $hardness = '';
    
    $np = strpos($block, "'name' => '");
    if ($np !== false) {
        $ns = $np + strlen("'name' => '");
        $ne = strpos($block, "'", $ns);
        while ($ne !== false && $ne > $ns && $block[$ne-1] === '\\') { $ne = strpos($block, "'", $ne + 1); }
        if ($ne !== false) $name = str_replace("\\'", "'", substr($block, $ns, $ne - $ns));
    }
    
    $sp = strpos($block, "'steel_type' => '");
    if ($sp !== false) {
        $ss = $sp + strlen("'steel_type' => '");
        $se = strpos($block, "'", $ss);
        while ($se !== false && $se > $ss && $block[$se-1] === '\\') { $se = strpos($block, "'", $se + 1); }
        if ($se !== false) $steel = str_replace("\\'", "'", substr($block, $ss, $se - $ss));
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
        if ($he !== false) $handle = str_replace("\\'", "'", substr($block, $hs, $he - $hs));
    }
    
    $hrp = strpos($block, "'hardness_hrc' => ");
    if ($hrp !== false) {
        $hrs = $hrp + strlen("'hardness_hrc' => ");
        $hre = strpos($block, ",", $hrs);
        if ($hre !== false) $hardness = trim(substr($block, $hrs, $hre - $hrs));
    }
    
    // Generate meta description: "Steel, length | Kitsuneoni"
    $newMeta = "$steel, {$length}cm | Kitsuneoni";
    if ($handle) $newMeta = "$steel, {$length}cm, $handle | Kitsuneoni";
    
    // Replace meta_description value
    $mdLabel = "'meta_description' => '";
    $mdPos = strpos($block, $mdLabel);
    if ($mdPos !== false) {
        $valStart = $mdPos + strlen($mdLabel);
        $valEnd = $valStart;
        while ($valEnd < strlen($block)) {
            if ($block[$valEnd] === "'" && ($valEnd === 0 || $block[$valEnd-1] !== '\\')) {
                break;
            }
            $valEnd++;
        }
        if ($valEnd < strlen($block)) {
            $block = substr_replace($block, $newMeta, $valStart, $valEnd - $valStart);
        }
    }
    
    $idx++;
}
unset($block);

$newProductsArea = implode("],\n    ", $blocks);
file_put_contents('database/seeders/DatabaseSeeder.php', $before . $newProductsArea . $after);

// Verify
$v = file_get_contents('database/seeders/DatabaseSeeder.php');
$checks = ['differential clay tempering', 'multi-layered pattern', 'premium collectible'];
foreach ($checks as $chk) {
    echo str_contains($v, $chk) ? "STILL HAS: $chk\n" : "REMOVED: $chk\n";
}
echo "Meta desc count: " . substr_count($v, "'meta_description' => '") . "\n";
echo "Prices: " . preg_match_all("/'price'\s*=>\s*\d+/", $v) . "\n";
