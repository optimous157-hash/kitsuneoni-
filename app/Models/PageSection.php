<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['key', 'title', 'content', 'data', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getContent(string $key, $default = null)
    {
        $section = static::where('key', $key)->where('is_active', true)->first();
        return $section ? $section->content : $default;
    }

    public static function getData(string $key, $default = null)
    {
        $section = static::where('key', $key)->where('is_active', true)->first();
        return $section ? $section->data : $default;
    }
}
