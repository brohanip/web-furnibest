<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'headline',
        'subtitle',
        'intro',
        'story',
        'materials_title',
        'colors_title',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'headline' => 'Tentang Kami',
            'subtitle' => 'FurniBest by Cacam Furniture Jepara',
            'intro' => 'Kami menghadirkan furniture berkualitas dengan craftsmanship Jepara yang teliti, untuk rumah yang lebih hangat dan fungsional.',
            'story' => "Berawal dari workshop di Jepara, FurniBest berkembang melayani kebutuhan furniture rumah tangga dan komersial. Setiap produk melalui proses seleksi bahan, finishing, dan pengecekan kualitas sebelum sampai ke tangan Anda.",
            'materials_title' => 'Bahan',
            'colors_title' => 'Sampel Warna',
        ]);
    }
}
