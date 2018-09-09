<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrBapbSender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_bapb_sender', function (Blueprint $table) {
            $table->bigIncrements('bapb_sender_id');
            $table->bigInteger('bapb_id');
            $table->bigInteger('sender_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bapb_id','tr_bapb_sender_bapb_id_fk')->references('bapb_id')->on('tr_bapb');
            $table->foreign('sender_id','tr_bapb_sender_sender_id_fk')
                ->references('sender_id')
                ->on('ms_sender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_bapb_sender', function (Blueprint $table) {
            $table->dropForeign('tr_bapb_sender_bapb_id_fk');
            $table->dropForeign('tr_bapb_sender_sender_id_fk');
        });

        Schema::drop('tr_bapb_sender');
    }
}
