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
        Schema::create('packing_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packing_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('inventory_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('qty');
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
        Schema::dropIfExists('packing_inventories');
    }
};
