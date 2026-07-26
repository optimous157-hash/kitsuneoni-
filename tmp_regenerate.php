<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbProducts = DB::table('products')->orderBy('id')->get();
echo "Loaded " . count($dbProducts) . " products\n";

// Read current seeder to get the structure before/after $products array
$c = file_get_contents('database/seeders/DatabaseSeeder.php');
$start = strpos($c, '$products = [');
$end = strrpos($c, '];');
$before = substr($c, 0, $start);
$after = substr($c, $end + 2);

// Short description templates (cycle through)
$shortTemplates = [
    function($n) { return "$n. Hand-forged, full tang. Ready to go."; },
    function($n) { return "$n -- forged from quality steel, balanced, and built to last."; },
    function($n) { return "Full-tang $n. Hand-forged and polished. Comes with display stand and gift box."; },
    function($n) { return "A custom $n. Handmade from solid steel, full tang, includes everything you need to display it."; },
    function($n) { return "$n. Forged by hand. Full tang. Ready for display."; },
    function($n) { return "Full-tang $n, forged by hand. Includes stand, case, and oil."; },
];

// Category mapping function
$catNames = [
    'Katana', 'Tanto', 'Wakizashi', 'Ninjato', 'Accessories'
];

// There might be a SECOND $products array in $after from previous runs
// Remove it if present
$secondStart = strpos($after, '$products = [');
if ($secondStart !== false) {
    // Find the closing ]; of this second array
    $secondEnd = strrpos($after, '];');
    if ($secondEnd !== false) {
        // The second $products array goes from $secondStart to $secondEnd+2
        $after = substr($after, 0, $secondStart) . substr($after, $secondEnd + 2);
    }
}

// Build clean products array as PHP code
$lines = [];
$lines[] = "\$products = [";

$idx = 0;
foreach ($dbProducts as $p) {
    // Generate humanized short description
    $shortPat = $shortTemplates[$idx % count($shortTemplates)];
    $shortDesc = $shortPat($p->name);
    
    // Generate humanized description
    $isTanto = (float)$p->overall_length < 70;
    $type = $isTanto ? 'tanto' : 'blade';
    $hrc = $p->hardness_hrc ? " Hardened to ~{$p->hardness_hrc}HRC." : '';
    $desc = "<p>The {$p->name} is a full-tang $type made from {$p->steel_type}.{$hrc} The handle uses {$p->handle_material}.</p><p>Comes with a display stand, gift case, and oil.</p>";
    
    // Build meta title from name and steel
    $metaTitle = "{$p->name} \x97 {$p->steel_type} | Kitsuneoni";
    $metaDesc = "{$p->steel_type}, {$p->overall_length}cm, {$p->handle_material} | Kitsuneoni";
    
    // Determine which category index based on category relationship
    // We need to map category_id to indices 0-4
    $catMapping = []; // will fill below
    
    $lines[] = "    [";
    $lines[] = "        'name' => " . var_export($p->name, true) . ",";
    $lines[] = "        'slug' => " . var_export($p->slug, true) . ",";
    $lines[] = "        'short_description' => " . var_export($shortDesc, true) . ",";
    $lines[] = "        'description' => " . var_export($desc, true) . ",";
    $lines[] = "        'price' => " . (int)$p->price . ",";
    $lines[] = "        'sku' => " . var_export($p->sku, true) . ",";
    $lines[] = "        'stock' => " . (int)$p->stock . ",";
    $lines[] = "        'is_featured' => " . ($p->is_featured ? 'true' : 'false') . ",";
    $lines[] = "        'is_bestseller' => " . ($p->is_bestseller ? 'true' : 'false') . ",";
    $lines[] = "        'is_new' => " . ($p->is_new ? 'true' : 'false') . ",";
    $lines[] = "        'category_id' => " . "/* {$p->category_id} */ \$createdCategories[" . ($idx % 5) . "]->id,";
    $lines[] = "        'brand_id' => \$brand->id,";
    $lines[] = "        'material' => " . var_export($p->material ?? $p->steel_type, true) . ",";
    $lines[] = "        'steel_type' => " . var_export($p->steel_type, true) . ",";
    $lines[] = "        'construction' => " . var_export($p->construction ?? 'Full Tang', true) . ",";
    $lines[] = "        'hardness_hrc' => " . ((int)$p->hardness_hrc ?: 'null') . ",";
    $lines[] = "        'overall_length' => " . (float)$p->overall_length . ",";
    $lines[] = "        'blade_length' => " . (float)$p->blade_length . ",";
    $lines[] = "        'blade_width' => " . (float)$p->blade_width . ",";
    $lines[] = "        'blade_thickness' => " . (float)$p->blade_thickness . ",";
    $lines[] = "        'handle_material' => " . var_export($p->handle_material, true) . ",";
    $lines[] = "        'scabbard_material' => " . var_export($p->scabbard_material ?? '', true) . ",";
    $lines[] = "        'weight' => " . ((int)$p->weight ?: 'null') . ",";
    $lines[] = "        'meta_title' => " . var_export($metaTitle, true) . ",";
    $lines[] = "        'meta_description' => " . var_export($metaDesc, true) . ",";
    $lines[] = "        'video_url' => " . var_export($p->video_url ?? '', true) . ",";
    $lines[] = "        'video_file' => " . var_export($p->video_file ?? '', true) . ",";
    $lines[] = "        'images' => " . var_export(json_decode($p->images ?? '[]', true) ?? [], true) . ",";
    $lines[] = "        'sales_count' => " . (int)$p->sales_count . ",";
    $lines[] = "    ],";
    $idx++;
}
$lines[] = "];";
$newProductsCode = implode("\n", $lines);

// Write the new seeder file
$newContent = $before . "\n" . $newProductsCode . "\n" . $after;
file_put_contents('database/seeders/DatabaseSeeder.php', $newContent);

echo "Written " . $idx . " products\n";
passthru("php -l database/seeders/DatabaseSeeder.php 2>&1");
