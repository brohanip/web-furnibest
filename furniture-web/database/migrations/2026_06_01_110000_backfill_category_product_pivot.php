<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillCategoryProductPivot extends Migration
{
    public function up()
    {
        // If products already have `category_id` from earlier single-category implementation,
        // copy those values into the pivot so existing data doesn't "disappear".
        if (Schema::hasColumn('products', 'category_id')) {
            DB::statement('
                INSERT IGNORE INTO category_product (category_id, product_id)
                SELECT category_id, id
                FROM products
                WHERE category_id IS NOT NULL
            ');
        }
    }

    public function down()
    {
        // No-op: we don't want to destroy pivot data automatically.
    }
}

