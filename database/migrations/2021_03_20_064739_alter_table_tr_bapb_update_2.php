<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrBapbUpdate2 extends Migration
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
              $table->string('perusahaan', 10)->nullable();
              $table->boolean('full_container')->nullable()->default(false);
              $table->json('full_container_data')->nullable()->default('{}');
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
              $table->dropColumn('full_container');
              $table->dropColumn('full_container_data');
              $table->dropColumn('perusahaan');
          }
        );
    }
}
