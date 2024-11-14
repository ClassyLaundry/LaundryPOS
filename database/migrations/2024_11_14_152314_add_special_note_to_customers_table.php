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
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->string('internal_note')->nullable()->after('status');
            $table->string('special_note')->nullable()->after('status');
            $table->dropColumn('secret_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn('internal_note');
            $table->dropColumn('special_note');
            $table->string('secret_note')->nullable()->after('status');
        });
    }
};
