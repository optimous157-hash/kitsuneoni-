<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$seederSlugs = ['autumn-dragon','black-lotus','blue-dragon','dragonfly','forest-spirit','kokuryu-tanto','muichiro-tokito-nichirin','sea-breeze','steel-storm','tanjiro-kamados-katana','the-wandering-warrior','winged-hawk','sanemi-shinazugawa-katana','kokushibo-katana','yoriichi-tsugikuni-katana'];
$extra = DB::table('products')->whereNotIn('slug', $seederSlugs)->orderBy('id')->get();

function fmt($v) {
    if ($v === null || $v === '') return "null";
    if (is_numeric($v)) return $v;
    return "'" . str_replace("'", "\\'", $v) . "'";
}
function fmtFloat($v) {
    if ($v === null || $v === '') return "null";
    return (float)$v;
}

$out = "";
foreach ($extra as $p) {
    $out .= "            [\n";
    $out .= "                'name' => " . fmt($p->name) . ",\n";
    $out .= "                'slug' => " . fmt($p->slug) . ",\n";
    $out .= "                'short_description' => " . fmt($p->short_description) . ",\n";
    $desc = $p->description ?? '';
    $out .= "                'description' => " . fmt($desc) . ",\n";
    $out .= "                'price' => " . fmtFloat($p->price) . ",\n";
    $out .= "                'sku' => " . fmt($p->sku) . ",\n";
    $out .= "                'stock' => " . (int)$p->stock . ",\n";
    $out .= "                'is_featured' => " . ($p->is_featured ? 'true' : 'false') . ",\n";
    $out .= "                'is_bestseller' => " . ($p->is_bestseller ? 'true' : 'false') . ",\n";
    $out .= "                'is_new' => " . ($p->is_new ? 'true' : 'false') . ",\n";
    $out .= "                'category_id' => \$createdCategories[" . ((int)$p->category_id - 1) . "]->id,\n";
    $out .= "                'brand_id' => \$brand->id,\n";
    $out .= "                'material' => " . fmt($p->material) . ",\n";
    $out .= "                'steel_type' => " . fmt($p->steel_type) . ",\n";
    $out .= "                'construction' => " . fmt($p->construction) . ",\n";
    $out .= "                'hardness_hrc' => " . fmtFloat($p->hardness_hrc) . ",\n";
    $out .= "                'overall_length' => " . fmtFloat($p->overall_length) . ",\n";
    $out .= "                'blade_length' => " . fmtFloat($p->blade_length) . ",\n";
    $out .= "                'blade_width' => " . fmtFloat($p->blade_width) . ",\n";
    $out .= "                'blade_thickness' => " . fmtFloat($p->blade_thickness) . ",\n";
    $out .= "                'handle_material' => " . fmt($p->handle_material) . ",\n";
    $out .= "                'scabbard_material' => " . fmt($p->scabbard_material) . ",\n";
    $out .= "                'weight' => " . fmtFloat($p->weight) . ",\n";
    $out .= "                'meta_title' => " . fmt($p->meta_title) . ",\n";
    $out .= "                'meta_description' => " . fmt($p->meta_description) . ",\n";
    $out .= "                'og_image' => " . fmt($p->og_image) . ",\n";
    $videoFile = $p->video_file ?? null;
    $videoUrl = $p->video_url ?? null;
    $out .= "                'video_url' => " . fmt($videoUrl) . ",\n";
    $out .= "                'video_file' => " . fmt($videoFile) . ",\n";
    $out .= "                'sales_count' => 0,\n";
    $out .= "            ],\n";
}
file_put_contents('tmp_seed_extra.txt', $out);
echo "Generated " . $extra->count() . " entries.\n";
echo "First 5 lines:\n" . implode("\n", array_slice(explode("\n", $out), 0, 6)) . "\n";
