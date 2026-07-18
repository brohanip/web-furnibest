<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->default('midtrans')->after('notes');
            $table->foreignId('bank_account_id')->nullable()->after('payment_method')->constrained()->nullOnDelete();
            $table->string('transfer_note')->nullable()->after('bank_account_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bank_account_id');
            $table->dropColumn(['payment_method', 'transfer_note']);
        });
    }
}
