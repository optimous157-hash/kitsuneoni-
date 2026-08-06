<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterWelcomeMail;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->inStock()
            ->with(['images', 'category'])
            ->limit(4)->get();

        $bestsellers = Product::active()->bestsellers()->inStock()
            ->with(['images', 'category'])
            ->limit(4)->get();

        $newArrivals = Product::active()->new()->inStock()
            ->with(['images', 'category'])
            ->limit(3)->get();

        $categories = Category::active()->root()->ordered()
            ->withCount(['activeProducts as products_count'])
            ->get();

        $testimonials = Testimonial::approved()->featured()->ordered()->limit(5)->get();

        $reviews = Review::approved()->featured()->ordered()
            ->with('product')
            ->limit(6)->get();

        $faqs = Faq::active()->ordered()->limit(6)->get();

        $stats = \Illuminate\Support\Facades\Cache::remember('homepage_stats', now()->addHours(1), function () {
            return [
                'products_sold' => Product::sum('sales_count'),
                'happy_customers' => Review::approved()->count('id'),
                'countries_served' => 50,
                'years_crafting' => 5,
            ];
        });

        return view('shop.home', compact(
            'featuredProducts', 'bestsellers', 'newArrivals',
            'categories', 'testimonials', 'reviews', 'faqs', 'stats'
        ));
    }

    public function newsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            [
                'is_active' => true,
                'subscribed_at' => now(),
            ]
        );

        try {
            Mail::to($subscriber->email)->queue(new NewsletterWelcomeMail($subscriber));
        } catch (\Exception $e) {
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Thank you for subscribing!']);
        }

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $products = Product::active()->inStock()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%")
                  ->orWhereHas('tags', function ($tq) use ($query) {
                      $tq->where('tag', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('category', function ($cq) use ($query) {
                      $cq->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->with(['images', 'category'])
            ->limit(10)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => $p->formatted_price,
                'image' => $p->primary_image_url,
                'category' => $p->category->name ?? '',
                'url' => $p->url,
            ]);

        return response()->json(['results' => $products]);
    }
}
