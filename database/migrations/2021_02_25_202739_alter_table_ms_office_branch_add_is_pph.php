<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMsOfficeBranchAddIsPph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'ms_office_branch',
          function (Blueprint $table)
          {
              $table->boolean('is_pph')->nullable();
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
          'ms_office_branch',
          function (Blueprint $table)
          {
              $table->dropColumn('is_pph');
          }
        );
    }
}
