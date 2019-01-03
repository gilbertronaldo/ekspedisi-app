<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTrBapbAddCalculation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_bapb', function (Blueprint $table) {
            $table->float('harga')->default(0);
            $table->float('cost')->default(0);
            $table->float('dimensi')->default(0);
            $table->float('berat')->default(0);
            $table->float('koli')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_bapb', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->dropColumn('cost');
            $table->dropColumn('dimensi');
            $table->dropColumn('berat');
            $table->dropColumn('koli');
        });
    }
}
