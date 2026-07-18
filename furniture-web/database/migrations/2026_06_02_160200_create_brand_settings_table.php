<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('brand_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brand_settings');
    }
}

