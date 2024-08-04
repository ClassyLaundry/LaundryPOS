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
        Schema::create('rewashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_transaksi_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('jenis_rewash_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('modified_by')
                ->constrained('users', 'id')
                ->cascadeOnDelete();
            $table->foreignId('pencuci')
                ->constrained('users', 'id')
                ->cascadeOnDelete();
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default(false);
            $table->string('proses_asal');
            $table->foreignId('submitter')
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
        Schema::dropIfExists('rewashes');
    }
};
