<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the 34 products NOT in the seeder (slug list from seeder)
$seederSlugs = ['autumn-dragon','black-lotus','blue-dragon','dragonfly','forest-spirit','kokuryu-tanto','muichiro-tokito-nichirin','sea-breeze','steel-storm','tanjiro-kamados-katana','the-wandering-warrior','winged-hawk','sanemi-shinazugawa-katana','kokushibo-katana','yoriichi-tsugikuni-katana'];
$extra = DB::table('products')->whereNotIn('slug', $seederSlugs)->orderBy('id')->get();

foreach ($extra as $p) {
    echo "=== " . $p->name . " | slug=" . $p->slug . " ===\n";
    echo "price=" . $p->price . " stock=" . $p->stock . " sku=" . ($p->sku ?? '') . "\n";
    echo "category_id=" . $p->category_id . " brand_id=" . $p->brand_id . "\n";
    echo "short=" . substr(strip_tags($p->short_description ?? ''),0,120) . "\n";
    echo "desc=" . substr(strip_tags($p->description ?? ''),0,200) . "\n";
    echo "material=" . ($p->material ?? '') . " steel=" . ($p->steel_type ?? '') . " construction=" . ($p->construction ?? '') . "\n";
    echo "hrc=" . $p->hardness_hrc . " overall=" . $p->overall_length . " blade=" . $p->blade_length . " width=" . $p->blade_width . " thick=" . $p->blade_thickness . "\n";
    echo "handle=" . ($p->handle_material ?? '') . "\n";
    echo "scabbard=" . ($p->scabbard_material ?? '') . "\n";
    echo "weight=" . ($p->weight ?? '') . " length=" . ($p->length ?? '') . "\n";
    echo "featured=" . (int)$p->is_featured . " bestseller=" . (int)$p->is_bestseller . " new=" . (int)$p->is_new . "\n";
    echo "meta_title=" . ($p->meta_title ?? '') . "\n";
    echo "video_url=" . ($p->video_url ?? '') . " video_file=" . ($p->video_file ?? '') . "\n";
    echo "\n";
}
echo "TOTAL EXTRA: " . $extra->count() . "\n";
