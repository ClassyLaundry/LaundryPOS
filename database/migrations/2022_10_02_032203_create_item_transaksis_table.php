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
        Schema::create('item_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('jenis_item_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->double('bobot_bucket')->default(0);
            $table->integer('harga_premium')->default(0);
            $table->string('status_proses');
            $table->double('qty')->default(1);
            $table->integer('diskon_jenis_item')->default(0);
            $table->double('total_bobot')->default(0);
            $table->double('total_premium')->default(0);
            $table->foreignId('modified_by')
                ->constrained('users', 'id')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('item_transaksis');
    }
};
