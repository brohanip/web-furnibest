<?php

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class BackfillProductSlugsAndImages extends Migration
{
    public function up()
    {
        $usedSlugs = [];

        foreach (Product::orderBy('id')->get() as $product) {
            if (! $product->slug) {
                $base = Str::slug($product->name) ?: 'produk-' . $product->id;
                $slug = $base;
                $i = 1;

                while (in_array($slug, $usedSlugs, true) || Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }

                $product->update(['slug' => $slug]);
                $usedSlugs[] = $slug;
            }

            if ($product->image && ! $product->images()->exists()) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $product->image,
                    'sort_order' => 0,
                ]);
            }
        }
    }

    public function down()
    {
        // Data backfill — no rollback needed.
    }
}
