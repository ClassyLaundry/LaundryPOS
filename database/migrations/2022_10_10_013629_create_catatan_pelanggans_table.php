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
        Schema::create('catatan_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('catatan_cuci')->nullable();
            $table->text('catatan_khusus')->nullable();
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
        Schema::dropIfExists('catatan_pelanggans');
    }
};
