<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Category;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function about()
    {
        return view('shop.about');
    }

    public function loyalty()
    {
        return view('shop.loyalty');
    }

    public function faq()
    {
        $faqs = Faq::active()->ordered()->get();
        return view('shop.faq', compact('faqs'));
    }

    public function wishlist()
    {
        return view('shop.wishlist');
    }

    public function contact()
    {
        return view('shop.contact');
    }

    public function contactSend(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactSubmission::create($data);

        try {
            Mail::raw(
                "Name: {$data['name']}\nEmail: {$data['email']}\nSubject: {$data['subject']}\n\n{$data['message']}",
                function ($msg) use ($data) {
                    $msg->to(config('site.contact.email') ?: 'orders@kitsuneoni.com')
                        ->subject('Contact Form: ' . ($data['subject'] ?: 'New Message'));
                }
            );
        } catch (\Exception $e) {
            Log::warning('Contact form mail failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Message sent! We\'ll respond within 24 hours.');
    }

    public function shipping()
    {
        return redirect()->route('faq', [], 301);
    }

    public function robots()
    {
        $disallow = config('app.env') === 'production' ? '' : '/';
        $sitemapUrl = url('/sitemap.xml');
        $content = "User-agent: *\nAllow: /\nDisallow: {$disallow}\nSitemap: {$sitemapUrl}\n";
        return response($content)->header('Content-Type', 'text/plain');
    }

    public function sitemap()
    {
        $products = Product::where('is_active', true)->get(['slug', 'updated_at']);
        $categories = Category::where('is_active', true)->get(['slug', 'updated_at']);

        return response()->view('sitemap', compact('products', 'categories'))
            ->header('Content-Type', 'application/xml');
    }
}