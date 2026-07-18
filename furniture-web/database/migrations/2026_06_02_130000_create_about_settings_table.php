<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('about_settings', function (Blueprint $table) {
            $table->id();
            $table->string('headline')->default('Tentang Kami');
            $table->string('subtitle')->nullable();
            $table->text('intro')->nullable();
            $table->text('story')->nullable();
            $table->string('materials_title')->default('Bahan');
            $table->string('colors_title')->default('Sampel Warna');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_settings');
    }
}
