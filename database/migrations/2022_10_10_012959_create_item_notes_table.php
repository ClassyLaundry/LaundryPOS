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
        Schema::create('item_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_transaksi_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('catatan');
            $table->boolean('front_top_left')->default(0);
            $table->boolean('front_top_right')->default(0);
            $table->boolean('front_bottom_left')->default(0);
            $table->boolean('front_bottom_right')->default(0);
            $table->boolean('back_top_left')->default(0);
            $table->boolean('back_top_right')->default(0);
            $table->boolean('back_bottom_left')->default(0);
            $table->boolean('back_bottom_right')->default(0);
            $table->text('image_path')->nullable();
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
        Schema::dropIfExists('item_notes');
    }
};
