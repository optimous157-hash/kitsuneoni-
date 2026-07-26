<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbProducts = DB::table('products')->orderBy('id')->get();
echo "Loaded " . count($dbProducts) . " products\n";

// Read the current seeder to get non-products parts
$c = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find all content BEFORE the first $products = [
$start = strpos($c, '$products = [');
$before = substr($c, 0, $start);

// Find content AFTER the products block by locating the last ];
// and then ensuring it's the right one (followed by something that's not another array)
$end = strrpos($c, '];');
$after = substr($c, $end + 2);

// Remove any leftover $products = [...] blocks from $after
while (true) {
    $remStart = strpos($after, '$products = [');
    if ($remStart === false) break;
    $remEnd = strrpos($after, '];');
    if ($remEnd === false) break;
    $after = substr($after, 0, $remStart) . substr($after, $remEnd + 2);
}

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A custom $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

// Generate $products array as PHP code
$code = "\$products = [\n";
$idx = 0;
foreach ($dbProducts as $p) {
    $shortPat = $shortTemplates[$idx % count($shortTemplates)];
    $shortDesc = $shortPat($p->name);
    
    $isTanto = (float)$p->overall_length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $hrc = $p->hardness_hrc ? " Hardened to ~{$p->hardness_hrc}HRC." : '';
    $desc = "<p>The {$p->name} is a full-tang $type made from {$p->steel_type}.{$hrc} The handle uses {$p->handle_material}.</p><p>Comes with a display stand, gift case, and oil.</p>";
    
    $metaTitle = "{$p->name} -- {$p->steel_type} | Kitsuneoni";
    $metaDesc = "{$p->steel_type}, {$p->overall_length}cm, {$p->handle_material} | Kitsuneoni";
    
    $images = json_decode($p->images ?? '[]', true) ?: [];
    
    $code .= "    [\n";
    $code .= "        'name' => " . var_export($p->name, true) . ",\n";
    $code .= "        'slug' => " . var_export($p->slug, true) . ",\n";
    $code .= "        'short_description' => " . var_export($shortDesc, true) . ",\n";
    $code .= "        'description' => " . var_export($desc, true) . ",\n";
    $code .= "        'price' => " . (int)$p->price . ",\n";
    $code .= "        'sku' => " . var_export($p->sku, true) . ",\n";
    $code .= "        'stock' => " . (int)$p->stock . ",\n";
    $code .= "        'is_featured' => " . ($p->is_featured ? 'true' : 'false') . ",\n";
    $code .= "        'is_bestseller' => " . ($p->is_bestseller ? 'true' : 'false') . ",\n";
    $code .= "        'is_new' => " . ($p->is_new ? 'true' : 'false') . ",\n";
    $code .= "        'category_id' => \$createdCategories[" . ($idx % 5) ."]->id,\n";
    $code .= "        'brand_id' => \$brand->id,\n";
    $code .= "        'material' => " . var_export($p->material ?? $p->steel_type, true) . ",\n";
    $code .= "        'steel_type' => " . var_export($p->steel_type, true) . ",\n";
    $code .= "        'construction' => " . var_export($p->construction ?? 'Full Tang', true) . ",\n";
    $code .= "        'hardness_hrc' => " . ((int)$p->hardness_hrc ?: 'null') . ",\n";
    $code .= "        'overall_length' => " . (float)$p->overall_length . ",\n";
    $code .= "        'blade_length' => " . (float)$p->blade_length . ",\n";
    $code .= "        'blade_width' => " . (float)$p->blade_width . ",\n";
    $code .= "        'blade_thickness' => " . (float)$p->blade_thickness . ",\n";
    $code .= "        'handle_material' => " . var_export($p->handle_material, true) . ",\n";
    $code .= "        'scabbard_material' => " . var_export($p->scabbard_material ?? '', true) . ",\n";
    $code .= "        'weight' => " . ((int)$p->weight ?: 'null') . ",\n";
    $code .= "        'meta_title' => " . var_export($metaTitle, true) . ",\n";
    $code .= "        'meta_description' => " . var_export($metaDesc, true) . ",\n";
    $code .= "        'video_url' => " . var_export($p->video_url ?? '', true) . ",\n";
    $code .= "        'video_file' => " . var_export($p->video_file ?? '', true) . ",\n";
    $code .= "        'images' => " . var_export($images, true) . ",\n";
    $code .= "        'sales_count' => " . (int)$p->sales_count . ",\n";
    $code .= "    ],\n";
    $idx++;
}
$code .= "];\n";

$newContent = $before . "\n" . $code . "\n" . $after;
file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);

echo "Written.\n";
passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");
