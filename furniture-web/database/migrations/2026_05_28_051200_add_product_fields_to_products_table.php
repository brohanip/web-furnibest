<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 12, 2)->default(0)->after('name');
            }

            if (!Schema::hasColumn('products', 'stock')) {
                $table->unsignedInteger('stock')->default(0)->after('price');
            }

            if (!Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->after('stock');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }

            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }

            if (Schema::hasColumn('products', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
}

