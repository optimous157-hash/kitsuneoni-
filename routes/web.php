<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::post('/newsletter', [HomeController::class, 'newsletter'])->name('newsletter.subscribe');

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('shop.product');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('shop.category');

Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{referenceNumber}/success', [OrderController::class, 'success'])->name('order.success');

Route::get('/about', function () {
    return view('shop.about');
})->name('about');

Route::get('/contact', function () {
    return view('shop.contact');
})->name('contact');

Route::get('/shipping', function () {
    return view('shop.shipping');
})->name('shipping');

Route::get('/loyalty', function () {
    return view('shop.loyalty');
})->name('loyalty');

Route::get('/faq', function () {
    $faqs = \App\Models\Faq::active()->ordered()->get();
    return view('shop.faq', compact('faqs'));
})->name('faq');

Route::get('/wishlist', function () {
    return view('shop.wishlist');
})->name('wishlist');

Route::get('/robots.txt', function () {
    $disallow = config('app.env') === 'production' ? '' : '/';
    $sitemapUrl = url('/sitemap.xml');
    $content = "User-agent: *\nAllow: /\nDisallow: {$disallow}\nSitemap: {$sitemapUrl}\n";
    return response($content)->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/sitemap.xml', function () {
    $products = \App\Models\Product::where('is_active', true)->get(['slug', 'updated_at']);
    $categories = \App\Models\Category::where('is_active', true)->get(['slug', 'updated_at']);

    return response()->view('sitemap', compact('products', 'categories'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
