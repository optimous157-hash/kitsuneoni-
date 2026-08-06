<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Shop\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::post('/newsletter', [HomeController::class, 'newsletter'])
    ->middleware('throttle:10,1')
    ->name('newsletter.subscribe');

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ProductController::class, 'show'])->name('shop.product');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('shop.category');

Route::get('/order', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('order.store');
Route::get('/order/{referenceNumber}/success', [OrderController::class, 'success'])->name('order.success');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactSend'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

Route::get('/shipping', [PageController::class, 'shipping'])->name('shipping');
Route::get('/loyalty', [PageController::class, 'loyalty'])->name('loyalty');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/wishlist', [PageController::class, 'wishlist'])->name('wishlist');

Route::get('/robots.txt', [PageController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');