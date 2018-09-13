<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBapbUpdate1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_bapb', function (Blueprint $table) {
            $table->string('tagih_di')->nullable();
            $table->string('no_container_1')->nullable();
            $table->string('no_container_2')->nullable();
            $table->string('no_seal')->nullable();
        });

        Schema::table('tr_bapb_sender', function (Blueprint $table) {
            $table->string('kemasan')->nullable();
            $table->string('krani')->nullable();
            $table->dateTime('entry_date')->nullable();
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
            $table->dropColumn('tagih_di');
            $table->dropColumn('no_container_1');
            $table->dropColumn('no_container_2');
            $table->dropColumn('no_seal');
        });

        Schema::table('tr_bapb_sender', function (Blueprint $table) {
            $table->dropColumn('kemasan');
            $table->dropColumn('krani');
            $table->dropColumn('entry_date');
        });
    }
}
