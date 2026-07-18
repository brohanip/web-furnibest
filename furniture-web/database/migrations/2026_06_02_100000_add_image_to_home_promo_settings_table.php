<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToHomePromoSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('home_promo_settings', function (Blueprint $table) {
            $table->string('image')->nullable()->after('install_note');
        });
    }

    public function down()
    {
        Schema::table('home_promo_settings', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
