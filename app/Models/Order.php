<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number', 'status', 'user_id',
        'customer_name', 'customer_email', 'customer_phone',
        'customer_country', 'customer_city', 'customer_address',
        'subtotal', 'shipping_cost', 'total', 'currency',
        'notes', 'ip_address', 'user_agent',
        'confirmed_at', 'processing_at', 'delivered_at', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total' => 'decimal:2',
            'confirmed_at' => 'datetime',
            'processing_at' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Order $order) {
            if (empty($order->reference_number)) {
                $order->reference_number = 'YO-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'processing' => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function markAsConfirmed(): void
    {
        $this->update(['status' => 'confirmed', 'confirmed_at' => now()]);
    }

    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing', 'processing_at' => now()]);
    }

    public function markAsDelivered(): void
    {
        $this->update(['status' => 'delivered', 'delivered_at' => now()]);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => 'cancelled', 'cancelled_at' => now()]);
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total, 0);
    }
}
