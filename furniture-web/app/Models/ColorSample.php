<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color_code',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getSwatchStyleAttribute(): string
    {
        if ($this->color_code && preg_match('/^#?[0-9A-Fa-f]{3,8}$/', $this->color_code)) {
            $hex = ltrim($this->color_code, '#');

            return 'background-color: #' . $hex;
        }

        return 'background-color: #d4d4d8';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
