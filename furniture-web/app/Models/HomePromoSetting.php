<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePromoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_label',
        'title',
        'subtitle',
        'discount_badge',
        'discount_note',
        'price_label',
        'price',
        'install_note',
        'image',
        'stat_rating_label',
        'stat_rating_value',
        'stat_sold_label',
        'stat_sold_value',
        'stat_support_label',
        'stat_support_value',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'package_label' => 'Paket ruang tamu',
            'title' => 'Nordic Living Set',
            'subtitle' => 'Sofa + meja + karpet',
            'discount_badge' => 'Diskon 20%',
            'discount_note' => 'hingga akhir bulan',
            'price_label' => 'Mulai dari',
            'price' => 3999000,
            'install_note' => 'Pasang di rumah dalam 2–3 hari',
            'stat_rating_label' => 'Rating',
            'stat_rating_value' => '4.8/5',
            'stat_sold_label' => 'Terjual',
            'stat_sold_value' => '1.2k+',
            'stat_support_label' => 'Support',
            'stat_support_value' => '7 hari',
            'is_active' => true,
        ]);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
