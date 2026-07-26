<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Services\ImageCompressionService;
use App\Services\ProductDataGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images']);

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_featured' => 'nullable|boolean',
            'is_bestseller' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'material' => 'nullable|string|max:255',
            'steel_type' => 'nullable|string|max:255',
            'construction' => 'nullable|string|max:255',
            'hardness_hrc' => 'nullable|numeric',
            'blade_length' => 'nullable|numeric',
            'overall_length' => 'nullable|numeric',
            'blade_width' => 'nullable|numeric',
            'blade_thickness' => 'nullable|numeric',
            'handle_material' => 'nullable|string|max:255',
            'scabbard_material' => 'nullable|string|max:255',
            'weight' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images.*' => 'image|mimes:jpeg,png,webp|max:5120',
            'tags' => 'nullable|string',
            'auto_fill' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tags = $validated['tags'] ?? '';
        unset($validated['tags']);

        $autoFill = $request->boolean('auto_fill');
        unset($validated['auto_fill']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_new'] = $request->boolean('is_new');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['in_stock'] = $validated['stock'] > 0;

        if ($autoFill && !empty($validated['name'])) {
            $generator = app(ProductDataGenerator::class);
            $generated = $generator->generateFromName($validated['name']);
            foreach ($generated as $key => $value) {
                if (empty($validated[$key])) {
                    $validated[$key] = $value;
                }
            }
            if (empty($tags)) {
                $tags = $generated['tags'] ?? '';
            }
            $specs = $generator->inferSpecsFromSimilar($validated['name']);
            foreach ($specs as $key => $value) {
                if (empty($validated[$key])) {
                    $validated[$key] = $value;
                }
            }
        }

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            $compressor = app(ImageCompressionService::class);
            $images = $request->file('images');
            foreach ($images as $index => $image) {
                $stored = $compressor->compressAndStore(
                    $image,
                    'products',
                    $product->slug . '-' . ($index + 1)
                );
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $stored['webp'],
                    'alt_text' => $product->name,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        if (!empty($tags)) {
            $tagArray = array_map('trim', explode(',', $tags));
            foreach ($tagArray as $tag) {
                if (!empty($tag)) {
                    $product->tags()->create(['tag' => $tag]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'tags', 'variants']);
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_featured' => 'nullable|boolean',
            'is_bestseller' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'material' => 'nullable|string|max:255',
            'steel_type' => 'nullable|string|max:255',
            'construction' => 'nullable|string|max:255',
            'hardness_hrc' => 'nullable|numeric',
            'blade_length' => 'nullable|numeric',
            'overall_length' => 'nullable|numeric',
            'blade_width' => 'nullable|numeric',
            'blade_thickness' => 'nullable|numeric',
            'handle_material' => 'nullable|string|max:255',
            'scabbard_material' => 'nullable|string|max:255',
            'weight' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images.*' => 'image|mimes:jpeg,png,webp|max:5120',
            'tags' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tags = $validated['tags'] ?? null;
        unset($validated['tags']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_bestseller'] = $request->boolean('is_bestseller');
        $validated['is_new'] = $request->boolean('is_new');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['in_stock'] = $validated['stock'] > 0;

        $product->update($validated);

        if ($request->hasFile('images')) {
            $compressor = app(ImageCompressionService::class);
            $images = $request->file('images');
            $existingCount = $product->images()->count();
            foreach ($images as $index => $image) {
                $stored = $compressor->compressAndStore(
                    $image,
                    'products',
                    $product->slug . '-' . ($existingCount + $index + 1)
                );
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $stored['webp'],
                    'alt_text' => $product->name,
                    'sort_order' => $existingCount + $index,
                    'is_primary' => false,
                ]);
            }
        }

        $product->tags()->delete();
        if (!empty($tags)) {
            $tagArray = array_map('trim', explode(',', $tags));
            foreach ($tagArray as $tag) {
                if (!empty($tag)) {
                    $product->tags()->create(['tag' => $tag]);
                }
            }
        }

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            if (str_starts_with($image->path, 'products/')) {
                $jpegPath = preg_replace('/\.webp$/', '.jpg', $image->path);
                Storage::disk('public')->delete([$image->path, $jpegPath]);
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function destroyImage(ProductImage $image)
    {
        $jpegPath = preg_replace('/\.webp$/', '.jpg', $image->path);
        Storage::disk('public')->delete([$image->path, $jpegPath]);
        $image->delete();
        if ($this->expectsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Image deleted.');
    }

    public function setPrimaryImage(ProductImage $image)
    {
        ProductImage::where('product_id', $image->product_id)
            ->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        if ($this->expectsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Primary image updated.');
    }
}
