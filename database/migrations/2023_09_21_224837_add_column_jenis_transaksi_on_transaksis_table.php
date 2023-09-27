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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('tipe_transaksi')
                ->nullable()
                ->after('parfum_id');

            $table->integer('diskon_pelanggan_spesial')
                ->default(0)
                ->after('diskon_member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('tipe_transaksi');
            $table->dropColumn('diskon_pelanggan_spesial');
        });
    }
};
