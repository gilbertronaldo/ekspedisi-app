<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrInvoiceBapb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          'tr_invoice_bapb',
          function (Blueprint $table)
          {
              $table->bigIncrements('invoice_bapb_id');

              $table->bigInteger('invoice_id');
              $table->bigInteger('bapb_id');

              $table->boolean('is_paid')->default(FALSE);
              $table->integer('payment_total')->default(0);
              $table->dateTime('payment_date')->nullable();

              $table->timestamps();
              $table->softDeletes();

              $table->foreign('invoice_id','tr_invoice_bapb_invoice_id_fk')->references('invoice_id')->on('ms_invoice');
              $table->foreign('bapb_id','tr_invoice_bapb_bapb_id_fk')->references('bapb_id')->on('tr_bapb');
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
        Schema::drop('tr_invoice_bapb');
    }
}
