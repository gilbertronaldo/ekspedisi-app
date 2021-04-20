<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrBapbAddTagihJkt extends Migration
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
              $table->boolean('tagih_jkt')->nullable()->default(false);
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
              $table->dropColumn('tagih_jkt');
          }
        );
    }
}
