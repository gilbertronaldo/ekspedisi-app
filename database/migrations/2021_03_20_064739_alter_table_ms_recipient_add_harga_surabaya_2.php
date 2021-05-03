<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMsRecipientAddHargaSurabaya2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
          'ms_recipient',
          function (Blueprint $table)
          {
              $table->bigInteger('price_document_surabaya')->nullable();
              $table->bigInteger('minimum_charge_surabaya')->nullable();
              $table->bigInteger('minimum_charge_calculation_id_surabaya')->nullable();
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
          'ms_recipient',
          function (Blueprint $table)
          {
              $table->dropColumn('price_document_surabaya');
              $table->dropColumn('minimum_charge_surabaya');
              $table->dropColumn('minimum_charge_calculation_id_surabaya');
          }
        );
    }
}
