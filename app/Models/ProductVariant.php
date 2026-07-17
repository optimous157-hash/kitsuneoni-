<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'name', 'value', 'price_modifier', 'stock', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_modifier' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute(): float
    {
        return $this->product->price + $this->price_modifier;
    }
}
