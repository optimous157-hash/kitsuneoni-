<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description',
        'price', 'compare_at_price', 'cost_price',
        'sku', 'stock', 'in_stock',
        'is_featured', 'is_bestseller', 'is_new', 'is_active',
        'sort_order', 'sales_count', 'views_count',
        'weight', 'length', 'material', 'steel_type',
        'construction', 'hardness_hrc', 'blade_length',
        'overall_length', 'blade_width', 'blade_thickness',
        'handle_material', 'scabbard_material',
        'category_id', 'brand_id',
        'meta_title', 'meta_description', 'og_image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'is_active' => 'boolean',
            'in_stock' => 'boolean',
            'sales_count' => 'integer',
            'views_count' => 'integer',
            'hardness_hrc' => 'decimal:1',
            'blade_length' => 'decimal:1',
            'overall_length' => 'decimal:1',
            'blade_width' => 'decimal:1',
            'blade_thickness' => 'decimal:1',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            $product->in_stock = $product->stock > 0;
        });
        static::updating(function (Product $product) {
            $product->in_stock = $product->stock > 0;
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(ProductTag::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function getUrlAttribute(): string
    {
        return route('shop.product', $this->slug);
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->primaryImage;
        if ($primary) {
            if (str_starts_with($primary->path, 'http')) {
                return $primary->path;
            }
            return asset('storage/' . $primary->path);
        }
        return $this->getFallbackImage();
    }

    private function getFallbackImage(): string
    {
        $images = [
            'sanemi-shinazugawa-katana' => 'https://cdn.pixabay.com/photo/2013/10/19/08/06/katana-197807_1280.jpg',
            'bushido-katana-classic-black' => 'https://cdn.pixabay.com/photo/2012/04/13/12/26/sword-32185_1280.png',
            'rengoku-flame-katana' => 'https://cdn.pixabay.com/photo/2013/07/12/14/45/katana-148716_1280.png',
            'mini-katana-desk-display' => 'https://cdn.pixabay.com/photo/2015/10/31/12/25/ninja-1015494_1280.jpg',
            'traditional-wakizashi' => 'https://cdn.pixabay.com/photo/2012/04/10/17/13/short-sword-26501_1280.png',
            'custom-tanto-blade' => 'https://cdn.pixabay.com/photo/2015/07/29/13/26/sword-866014_1280.jpg',
            'premium-sword-display-stand' => 'https://cdn.pixabay.com/photo/2012/11/28/10/48/samurai-67662_1280.jpg',
            'sword-maintenance-kit' => 'https://cdn.pixabay.com/photo/2012/11/28/01/28/emperor-67466_1280.jpg',
        ];
        return $images[$this->slug] ?? 'https://cdn.pixabay.com/photo/2013/10/19/08/06/katana-197807_1280.jpg';
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if ($this->compare_at_price && $this->compare_at_price > $this->price) {
            return round((1 - $this->price / $this->compare_at_price) * 100);
        }
        return null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 0);
    }

    public function getPriceByRegion(string $region): float
    {
        $prices = [
            'cis' => $this->price,
            'europe' => $this->price,
            'america' => $this->price,
            'africa' => $this->price * 1.065,
            'australia' => $this->price * 1.065,
        ];
        return $prices[$region] ?? $this->price;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getTagNamesAttribute(): array
    {
        return $this->tags->pluck('tag')->toArray();
    }
}
