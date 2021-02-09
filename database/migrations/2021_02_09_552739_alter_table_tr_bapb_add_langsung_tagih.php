<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrBapbAddLangsungTagih extends Migration
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
              $table->boolean('langsung_tagih')->default(false);
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
              $table->dropColumn('langsung_tagih');
          }
        );
    }
}
