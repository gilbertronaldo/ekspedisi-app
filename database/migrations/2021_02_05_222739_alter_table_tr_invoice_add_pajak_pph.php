<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrInvoiceAddPajakPph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'tr_invoice',
          function (Blueprint $table)
          {
              $table->string('pajak', 30)->nullable();
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
          'tr_invoice',
          function (Blueprint $table)
          {
              $table->dropColumn('pajak');
              $table->dropColumn('is_pph');
          }
        );
    }
}
