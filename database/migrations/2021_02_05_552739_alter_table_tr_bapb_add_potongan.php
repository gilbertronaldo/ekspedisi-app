<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrBapbAddPotongan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'tr_bapb',
          function (Blueprint $table)
          {
              $table->decimal('potongan', 15, 0)->nullable();
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
          'tr_bapb',
          function (Blueprint $table)
          {
              $table->dropColumn('potongan');
          }
        );
    }
}
