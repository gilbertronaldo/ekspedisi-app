<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrBapb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_bapb', function (Blueprint $table) {
            $table->bigIncrements('bapb_id');
            $table->string('bapb_no', 10);
            $table->text('bapb_description')->nullable();
            $table->bigInteger('ship_id')->nullable();
            $table->bigInteger('recipient_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ship_id','tr_bapb_ship_id_fk')->references('ship_id')->on('ms_ship');
            $table->foreign('recipient_id','tr_bapb_recipient_id_fk')->references('recipient_id')->on('ms_recipient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_bapb', function (Blueprint $table) {
            $table->dropForeign('tr_bapb_ship_id_fk');
            $table->dropForeign('tr_bapb_recipient_id_fk');
        });

        Schema::drop('tr_bapb');
    }
}
