<?php
// Humanize product descriptions in seeder
$c = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find all product blocks
$pattern = "/\[\s*'name'\s*=>\s*'([^']+)'[\s\S]*?'short_description'\s*=>\s*'([^']*)'[\s\S]*?'description'\s*=>\s*'([^']*)'/";
preg_match_all($pattern, $c, $matches, PREG_SET_ORDER);

$shortTemplates = [
    // Template 0: casual intro
    function($name) { return "$name. Hand-forged, full tang. Ready to go."; },
    // Template 1: direct
    function($name) { return "$name — forged from quality steel, balanced, and built to last."; },
    // Template 2: simple
    function($name) { return "Full-tang $name. Hand-forged and polished. Comes with display stand and gift box."; },
    // Template 3: collector-focused
    function($name) { return "A collector's $name. Handmade from solid steel, full tang, includes everything you need to display it."; },
    // Template 4: short and punchy
    function($name) { return "$name. Forged by hand. Full tang. Ready for display."; },
    // Template 5: slightly more descriptive but still natural
    function($name) { return "Full-tang $name, forged by hand. Includes stand, case, and oil."; },
];

// Build a mapping of product name to its key specs
// Extract specs from each product block
$specs = [];
foreach ($matches as $m) {
    $full = $m[0];
    $name = $m[1];
    $oldShort = $m[2];
    $oldDesc = $m[3];
    
    // Extract specs
    $steel = '';
    $length = '';
    $handle = '';
    $hardness = '';
    
    if (preg_match("/'steel_type'\s*=>\s*'([^']+)'/", $full, $sm)) $steel = $sm[1];
    if (preg_match("/'overall_length'\s*=>\s*([\d.]+)/", $full, $lm)) $length = $lm[1];
    if (preg_match("/'handle_material'\s*=>\s*'([^']+)'/", $full, $hm)) $handle = $hm[1];
    if (preg_match("/'hardness_hrc'\s*=>\s*(\d+)/", $full, $hrm)) $hardness = $hrm[1];
    
    $specs[$name] = [
        'steel' => $steel,
        'length' => $length,
        'handle' => $handle,
        'hardness' => $hardness,
        'oldShort' => $oldShort,
        'oldDesc' => $oldDesc,
    ];
}

// Generate new descriptions
$count = 0;
$newContent = $c;
foreach ($matches as $m) {
    $name = $m[1];
    $full = $m[0];
    $oldShort = $m[2];
    $oldDesc = $m[3];
    $spec = $specs[$name];
    
    // Pick a template
    $tplIdx = $count % count($shortTemplates);
    $newShort = $shortTemplates[$tplIdx]($name);
    
    // Build a natural-sounding full description
    $isTanto = (float)$spec['length'] < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    
    $descParts = [];
    $descParts[] = "<p>The $name is a full-tang $type forged from {$spec['steel']}.";
    if ($spec['hardness']) {
        $descParts[] = " Hardened to ~{$spec['hardness']}HRC.";
    }
    $descParts[] = " The handle uses {$spec['handle']}.</p>";
    
    $descParts[] = "<p>It comes with a display stand, a gift case, and maintenance oil. Ready to display right out of the box.</p>";
    
    $newDesc = implode('', $descParts);
    
    // Replace in content (first occurrence only - we iterate through matches)
    $pos = strpos($newContent, $oldShort);
    if ($pos !== false) {
        $newContent = substr_replace($newContent, $newShort, $pos, strlen($oldShort));
    }
    
    // Find and replace description (after short_description was already replaced)
    $pos2 = strpos($newContent, $oldDesc);
    if ($pos2 !== false) {
        $newContent = substr_replace($newContent, $newDesc, $pos2, strlen($oldDesc));
    }
    
    $count++;
}

file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);
echo "Updated $count product descriptions.\n";

// Verify
$v = file_get_contents('database/seeders/DatabaseSeeder.php');
preg_match_all("/'short_description'\s*=>\s*'([^']+)'/", $v, $sm);
echo "First 3 new short descriptions:\n";
for ($i = 0; $i < min(3, count($sm[1])); $i++) {
    echo "  {$sm[1][$i]}\n";
}
