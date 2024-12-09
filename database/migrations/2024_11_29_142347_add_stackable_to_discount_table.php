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
        Schema::table('diskons', function (Blueprint $table) {
            $table->integer('max_usage_per_customer')->default(1)->after('jenis_diskon');
            $table->boolean('is_stackable')->default(0)->after('jenis_diskon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diskons', function (Blueprint $table) {
            $table->dropColumn('max_usage_per_customer');
            $table->dropColumn('is_stackable');
        });
    }
};
