<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorSamplesTable extends Migration
{
    public function up()
    {
        Schema::create('color_samples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color_code', 20)->nullable();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('color_samples');
    }
}
