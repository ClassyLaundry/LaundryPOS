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
        Schema::create('jenis_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('nama');
            $table->string('unit');
            $table->double('bobot_bucket');
            $table->integer('harga_kilo');
            $table->integer('harga_bucket');
            $table->integer('harga_premium');
            $table->boolean('status_kilo')->default(false);
            $table->boolean('status_bucket')->default(false);
            $table->boolean('status_premium')->default(false);
            $table->boolean('status_item')->default(true);
            $table->integer('diskon_jenis_item')->default(0);
            $table->double('beban_produksi')->default(0.0);
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
        Schema::dropIfExists('jenis_items');
    }
};
