<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryPresetSeeder extends Seeder
{
    public function run()
    {
        $presets = [
            [
                'name' => 'Sofa',
                'slug' => 'sofa',
            ],
            [
                'name' => 'Almari',
                'slug' => 'almari',
            ],
            [
                'name' => 'Buffet',
                'slug' => 'buffet',
            ],
            [
                'name' => 'Dipan',
                'slug' => 'dipan',
            ],
            [
                'name' => 'Meja Makan',
                'slug' => 'meja-makan',
            ],
            [
                'name' => 'Produk Unggulan',
                'slug' => 'produk-unggulan',
            ],
        ];

        foreach ($presets as $preset) {
            Category::updateOrCreate(
                ['slug' => $preset['slug']],
                [
                    'name' => $preset['name'],
                    'description' => null,
                    'image' => null,
                ]
            );
        }
    }
}

