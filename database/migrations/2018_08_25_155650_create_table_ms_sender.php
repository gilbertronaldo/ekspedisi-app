<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMsSender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_sender', function (Blueprint $table) {
            $table->bigIncrements('sender_id');
            $table->string('sender_code');
            $table->string('sender_name');
            $table->string('sender_name_bapb')->nullable();
            $table->string('sender_name_other')->nullable();
            $table->string('sender_phone');
            $table->text('sender_address')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('price_ton')->nullable();
            $table->bigInteger('price_meter')->nullable();
            $table->bigInteger('minimum_charge')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id','ms_sender_city_id_fk')->references('city_id')->on('ms_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_sender', function (Blueprint $table) {
            $table->dropForeign('ms_sender_city_id_fk');
        });

        Schema::drop('ms_sender');
    }
}
