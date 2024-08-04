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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('transaksi_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('saldo_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('nominal');
            $table->string('metode_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};
