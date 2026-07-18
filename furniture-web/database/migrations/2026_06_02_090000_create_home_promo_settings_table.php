<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePromoSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('home_promo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('package_label')->default('Paket ruang tamu');
            $table->string('title')->default('Nordic Living Set');
            $table->string('subtitle')->nullable();
            $table->string('discount_badge')->nullable();
            $table->string('discount_note')->nullable();
            $table->string('price_label')->default('Mulai dari');
            $table->decimal('price', 12, 2)->default(0);
            $table->string('install_note')->nullable();
            $table->string('stat_rating_label')->default('Rating');
            $table->string('stat_rating_value')->default('4.8/5');
            $table->string('stat_sold_label')->default('Terjual');
            $table->string('stat_sold_value')->default('1.2k+');
            $table->string('stat_support_label')->default('Support');
            $table->string('stat_support_value')->default('7 hari');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_promo_settings');
    }
}
