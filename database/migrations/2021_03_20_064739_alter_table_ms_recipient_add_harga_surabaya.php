<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMsRecipientAddHargaSurabaya extends Migration
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
              $table->bigInteger('price_ton_surabaya')->nullable();
              $table->bigInteger('price_meter_surabaya')->nullable();
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
              $table->dropColumn('price_ton_surabaya');
              $table->dropColumn('price_meter_surabaya');
          }
        );
    }
}
