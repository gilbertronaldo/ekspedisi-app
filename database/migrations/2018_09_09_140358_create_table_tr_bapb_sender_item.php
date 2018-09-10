<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrBapbSenderItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_bapb_sender_item', function (Blueprint $table) {
            $table->bigIncrements('bapb_sender_item_id');
            $table->bigInteger('bapb_sender_id');
            $table->string('bapb_sender_item_name')->nullable();
            $table->integer('koli')->nullable();
            $table->integer('panjang')->nullable();
            $table->integer('lebar')->nullable();
            $table->integer('tinggi')->nullable();
            $table->integer('berat')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bapb_sender_id', 'tr_bapb_sender_item_bapb_sender_id_fk')
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
        Schema::table('tr_bapb_sender_item', function (Blueprint $table) {
            $table->dropForeign('tr_bapb_sender_item_bapb_sender_id_fk');
        });

        Schema::drop('tr_bapb_sender_item');
    }
}
