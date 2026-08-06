<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->inStock()->with(['images', 'category', 'brand']);

        if ($category = $request->input('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($brand = $request->input('brand')) {
            $query->whereHas('brand', fn ($q) => $q->where('slug', $brand));
        }

        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%")
                  ->orWhereHas('tags', fn ($tq) => $tq->where('tag', 'LIKE', "%{$search}%"));
            });
        }

        if ($material = $request->input('material')) {
            $query->where('material', $material);
        }

        $sort = $request->input('sort', 'newest');
        $query = match($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name'),
            'popular' => $query->orderBy('sales_count', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->ordered(),
        };

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::active()->root()->ordered()
            ->withCount('activeProducts')
            ->get();

        $brands = Brand::active()->withCount('products')->get();

        return view('shop.products', compact(
            'products', 'categories', 'brands'
        ));
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->withReviewAggregates()
            ->with([
                'images',
                'category',
                'brand',
                'variants' => fn ($q) => $q->where('is_active', true),
                'tags',
                'reviews' => fn ($q) => $q->approved()->ordered()->limit(10),
            ])
            ->firstOrFail();

        $product->incrementViews();

        $related = Product::active()->inStock()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with(['images', 'category'])
            ->limit(4)
            ->get();

        $recentlyViewed = collect(session('recently_viewed', []))
            ->filter(fn ($id) => $id != $product->id)
            ->take(4);

        if ($recentlyViewed->isNotEmpty()) {
            $recentlyViewed = Product::active()->whereIn('id', $recentlyViewed)
                ->with(['images', 'category'])->get();
        } else {
            $recentlyViewed = collect();
        }

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('shop.index')],
            ['label' => $product->category->name, 'url' => $product->category->url],
            ['label' => $product->name, 'url' => null],
        ];

        session()->push('recently_viewed', $product->id);
        session()->put('recently_viewed', array_slice(session('recently_viewed', []), -20));

        return view('shop.product', compact('product', 'related', 'recentlyViewed', 'breadcrumbs'));
    }
}
