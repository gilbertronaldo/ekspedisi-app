<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrBapbSenderAddBeratDimensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'tr_bapb_sender',
          function (Blueprint $table)
          {
              $table->integer('dimensi')->nullable();
              $table->integer('berat')->nullable();
          }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
          'tr_bapb_sender',
          function (Blueprint $table)
          {
              $table->dropColumn('dimensi');
              $table->dropColumn('berat');
          }
        );
    }
}
