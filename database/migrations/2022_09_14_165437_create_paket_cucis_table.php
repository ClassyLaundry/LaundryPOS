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
        Schema::create('paket_cucis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('deskripsi')->nullable();
            $table->integer('harga_paket');
            $table->integer('harga_per_bobot');
            $table->integer('jumlah_bobot');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('paket_cucis');
    }
};
