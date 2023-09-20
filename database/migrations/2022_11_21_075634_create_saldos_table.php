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
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('outlet_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('paket_deposit_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('nominal');
            $table->string('jenis_input');
            $table->integer('saldo_akhir');
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
        Schema::dropIfExists('saldos');
    }
};
