<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'type', 'description', 'properties', 'ip_address',
    ];

    protected function casts(): array
    {
        return ['properties' => 'array'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $type, string $description, array $properties = [], $user = null): static
    {
        return static::create([
            'user_id' => $user?->id ?? auth()->id(),
            'type' => $type,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
        ]);
    }
}
