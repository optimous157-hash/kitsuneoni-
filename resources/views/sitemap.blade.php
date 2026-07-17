<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('shop.index') }}</loc>
        <priority>0.9</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <priority>0.7</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('faq') }}</loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('shipping') }}</loc>
        <priority>0.6</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('loyalty') }}</loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('order.create') }}</loc>
        <priority>0.5</priority>
        <changefreq>monthly</changefreq>
    </url>
@foreach($categories as $category)
    <url>
        <loc>{{ route('shop.category', $category->slug) }}</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $category->updated_at->toW3cString() }}</lastmod>
    </url>
@endforeach
@foreach($products as $product)
    <url>
        <loc>{{ route('shop.product', $product->slug) }}</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
        <lastmod>{{ $product->updated_at->toW3cString() }}</lastmod>
    </url>
@endforeach
</urlset>
