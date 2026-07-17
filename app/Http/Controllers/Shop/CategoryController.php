<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->with(['children' => fn ($q) => $q->active()->ordered()])
            ->firstOrFail();

        $query = Product::active()->inStock()
            ->where('category_id', $category->id)
            ->with(['images', 'category', 'brand']);

        if ($request = request()) {
            if ($brand = $request->input('brand')) {
                $query->whereHas('brand', fn ($q) => $q->where('slug', $brand));
            }
            if ($minPrice = $request->input('min_price')) {
                $query->where('price', '>=', $minPrice);
            }
            if ($maxPrice = $request->input('max_price')) {
                $query->where('price', '<=', $maxPrice);
            }
            $sort = $request->input('sort', 'newest');
            $query = match($sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'name' => $query->orderBy('name'),
                'popular' => $query->orderBy('sales_count', 'desc'),
                default => $query->orderBy('created_at', 'desc'),
            };
        }

        $products = $query->paginate(12)->withQueryString();

        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Shop', 'url' => route('shop.index')],
            ['label' => $category->name, 'url' => null],
        ];

        return view('shop.category', compact('category', 'products', 'breadcrumbs'));
    }
}
