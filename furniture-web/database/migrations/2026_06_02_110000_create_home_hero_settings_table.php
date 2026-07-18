<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeHeroSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('home_hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_hero_settings');
    }
}
