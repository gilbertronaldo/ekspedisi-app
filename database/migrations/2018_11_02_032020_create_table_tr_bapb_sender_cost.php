<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrBapbSenderCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_bapb_sender_cost', function (Blueprint $table) {
            $table->bigIncrements('bapb_sender_cost_id');
            $table->bigInteger('bapb_sender_id');
            $table->string('bapb_sender_cost_name')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bapb_sender_id', 'tr_bapb_sender_cost_bapb_sender_id_fk')
                ->references('bapb_sender_id')
                ->on('tr_bapb_sender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_bapb_sender_cost', function (Blueprint $table) {
            $table->dropForeign('tr_bapb_sender_cost_bapb_sender_id_fk');
        });

        Schema::drop('tr_bapb_sender_cost');
    }
}
