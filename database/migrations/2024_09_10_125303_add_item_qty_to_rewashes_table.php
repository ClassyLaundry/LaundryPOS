<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewashes', function (Blueprint $table) {
            $table->integer('item_transaksi_qty')->default(1)->after('item_transaksi_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rewashes', function (Blueprint $table) {
            $table->dropColumn('item_transaksi_qty');
        });
    }
};
