<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\ContactController;

Route::prefix('admin')->name('admin.')->middleware('web')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductController::class)->except(['show']);
        Route::delete('/products/image/{image}', [ProductController::class, 'destroyImage'])->name('products.image.destroy');
        Route::post('/products/image/{image}/primary', [ProductController::class, 'setPrimaryImage'])->name('products.image.primary');

        Route::resource('categories', CategoryController::class)->except(['show']);

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('/orders/export/csv', [OrderController::class, 'export'])->name('orders.export');

        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::put('/customers/{customer}/toggle', [CustomerController::class, 'toggleStatus'])->name('customers.toggle');

        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
        Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
        Route::post('/reviews/{review}/feature', [ReviewController::class, 'toggleFeatured'])->name('reviews.feature');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

        Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
        Route::delete('/newsletter/{subscriber}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');

        Route::get('/content/sections', [ContentController::class, 'sections'])->name('content.sections');
        Route::put('/content/sections/{key}', [ContentController::class, 'updateSection'])->name('content.sections.update');
        Route::get('/content/faqs', [ContentController::class, 'faqs'])->name('content.faqs');
        Route::post('/content/faqs', [ContentController::class, 'storeFaq'])->name('content.faqs.store');
        Route::delete('/content/faqs/{faq}', [ContentController::class, 'destroyFaq'])->name('content.faqs.destroy');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
