<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get DB data for both admin user and categories
$dbProducts = DB::table('products')->orderBy('id')->get();
$categories = DB::table('categories')->get();
$brand = DB::table('brands')->first();
$faqs = DB::table('faqs')->get();
$settings = DB::table('settings')->get();

echo "Loaded " . count($dbProducts) . " products\n";

// Read the ORIGINAL (reference) seeder to get the correct structure
$ref = file_get_contents('database/seeders/DatabaseSeeder.php');

// Find the first $products = [ block
$firstStart = strpos($ref, '$products = [');
$before = substr($ref, 0, $firstStart);

// Now find the LAST ]; that closes the FIRST $products block
// We need to find the matching ] for the first [
// Simple approach: find all $products blocks, and take the content after the last one
$allStarts = [];
$pos = 0;
while (($pos = strpos($ref, '$products = [', $pos)) !== false) {
    $allStarts[] = $pos;
    $pos++;
}
echo "Found " . count($allStarts) . " products blocks\n";

// Take the LAST products block as the one to regenerate from
// Actually, we know the LAST products block is the most recent generated one
// Let's just work with ALL content BEFORE the first $products and AFTER the last

// Content before first $products block
$beforeContent = substr($ref, 0, $allStarts[0]);

// Content after the LAST $products block
// Find the last ]; in the file
$lastEnd = strrpos($ref, '];');
$afterContent = substr($ref, $lastEnd + 2);

// Remove any remaining $products blocks from $after
while (true) {
    $rs = strpos($afterContent, '$products = [');
    if ($rs === false) break;
    $re = strrpos($afterContent, '];');
    if ($re === false) break;
    $afterContent = substr($afterContent, 0, $rs) . substr($afterContent, $re + 2);
}

echo "Before length: " . strlen($beforeContent) . "\n";
echo "After length: " . strlen($afterContent) . "\n";

$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A custom $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

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

$newContent = $beforeContent . "\n" . $code . "\n" . $afterContent;
file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);

echo "Written $idx products\n";
passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");

$v = file_get_contents('database/seeders/DatabaseSeeder.php');
echo "File size: " . strlen($v) . "\n";
echo "Products arrays: " . substr_count($v, '$products = [') . "\n";
