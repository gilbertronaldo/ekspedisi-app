<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrInvoice extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          'tr_invoice',
          function (Blueprint $table)
          {
              $table->bigIncrements('invoice_id');
              $table->string('invoice_no', 10);

              $table->boolean('is_paid')->default(FALSE);
              $table->integer('payment_total')->default(0);
              $table->dateTime('payment_date')->nullable();

              $table->timestamps();
              $table->softDeletes();
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
        Schema::drop('tr_invoice');
    }
}
