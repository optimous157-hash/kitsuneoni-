<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ImageCompressionService;
use App\Services\ProductDataGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImportProduct extends Command
{
    protected $signature = 'product:import
        {name? : Product name (inferred from folder if not given)}
        {--dir= : Directory containing product images}
        {--price= : Product price in USD}
        {--category= : Category ID or slug}
        {--stock= : Stock quantity (default: 1)}
        {--sku= : Product SKU}
        {--featured : Mark as featured}
        {--bestseller : Mark as bestseller}
        {--no-fill : Skip auto-fill of missing data}';

    protected $description = 'Import a product with images and auto-generated data';

    public function handle(): int
    {
        $dir = $this->option('dir');
        $productName = $this->argument('name');

        if ($dir) {
            if (!is_dir($dir)) {
                $this->error("Directory not found: $dir");
                return self::FAILURE;
            }
            $files = glob($dir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
            if (empty($files)) {
                $this->error("No image files found in: $dir");
                return self::FAILURE;
            }
            if (!$productName) {
                $productName = basename($dir);
            }
            $this->info("Found " . count($files) . " files in '$dir'");
        } elseif (!$productName) {
            $this->error('Either provide a product name or --dir with images');
            return self::FAILURE;
        }

        $generator = app(ProductDataGenerator::class);
        $generated = $generator->generateFromName($productName);

        $this->line("--- Product: <fg=yellow>$productName</> ---");

        $name = $this->ask('Name', $productName);
        $slug = Str::slug($name);

        $price = $this->option('price') ?: $this->ask('Price (USD)');
        $categoryInput = $this->option('category') ?: $this->anticipate('Category', function () {
            return Category::pluck('name', 'id')->map(fn($n, $id) => "$id: $n")->values()->toArray();
        });

        $categoryId = null;
        if (is_numeric($categoryInput)) {
            $categoryId = (int) $categoryInput;
        } else {
            $cat = Category::where('slug', $categoryInput)->orWhere('name', $categoryInput)->first();
            $categoryId = $cat?->id;
        }
        if (!$categoryId || !Category::find($categoryId)) {
            $this->warn("Category not found, using generated: {$generated['category_id']}");
            $categoryId = $generated['category_id'];
        }

        $stock = $this->option('stock') ?: $this->ask('Stock', (string) rand(3, 20));
        $sku = $this->option('sku') ?: $this->ask('SKU (optional)', strtoupper(Str::random(8)));

        $autoFill = !$this->option('no-fill');

        $data = [
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'category_id' => $categoryId,
            'stock' => $stock,
            'sku' => $sku,
            'in_stock' => (int) $stock > 0,
            'is_active' => true,
            'is_featured' => $this->option('featured'),
            'is_bestseller' => $this->option('bestseller'),
            'is_new' => true,
        ];

        if ($autoFill) {
            $generated = $generator->generateFromName($name);
            foreach ($generated as $key => $value) {
                if (empty($data[$key])) {
                    $data[$key] = $value;
                }
            }
            $specs = $generator->inferSpecsFromSimilar($name);
            foreach ($specs as $key => $value) {
                if (empty($data[$key])) {
                    $data[$key] = $value;
                }
            }
            $this->info("Auto-filled missing data from name: $name");
        }

        $brand = Brand::first();
        if ($brand) {
            $data['brand_id'] = $brand->id;
        }

        $product = Product::create($data);

        if (!empty($generated['tags'])) {
            $tagArray = array_map('trim', explode(',', $generated['tags']));
            foreach ($tagArray as $tag) {
                if (!empty($tag)) {
                    $product->tags()->create(['tag' => $tag]);
                }
            }
        }

        if ($dir) {
            $compressor = app(ImageCompressionService::class);
            $imageFiles = array_filter($files, function ($file) {
                return !in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['mp4', 'webm', 'ogg']);
            });
            $imageFiles = array_values($imageFiles);
            sort($imageFiles);

            foreach ($imageFiles as $index => $imgPath) {
                $uploaded = new \Illuminate\Http\UploadedFile($imgPath, basename($imgPath));
                $stored = $compressor->compressAndStore($uploaded, 'products', $slug . '-' . ($index + 1));
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $stored['webp'],
                    'alt_text' => $name,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
                $this->line("  Image {$index}: {$stored['webp']}");
            }

        }

        $this->info("Product #{$product->id} '{$product->name}' created successfully!");
        $this->line("  URL: " . route('admin.products.edit', $product));
        $this->line("  Frontend: " . route('shop.product', $product->slug));

        return self::SUCCESS;
    }
}
