<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTrBapbAddPayment extends Migration
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
              $table->boolean('is_paid')->default(false);
              $table->decimal('payment_total', 15, 0)->nullable();
              $table->date('payment_date')->nullable();
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
              $table->dropColumn('is_paid');
              $table->dropColumn('payment_total');
              $table->dropColumn('payment_date');
          }
        );
    }
}
