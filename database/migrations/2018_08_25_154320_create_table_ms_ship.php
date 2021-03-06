<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMsShip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_ship', function (Blueprint $table) {
            $table->bigIncrements('ship_id');
            $table->string('no_voyage');
            $table->string('ship_name');
            $table->text('ship_description')->nullable();
            $table->timestamp('sailing_date')->nullable();
            $table->bigInteger('city_id_from')->nullable();
            $table->bigInteger('city_id_to')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id_from','ms_ship_city_id_from_fk')->references('city_id')->on('ms_city');
            $table->foreign('city_id_to','ms_ship_city_id_to_fk')->references('city_id')->on('ms_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_ship', function (Blueprint $table) {
            $table->dropForeign('ms_ship_city_id_from_fk');
            $table->dropForeign('ms_ship_city_id_to_fk');
        });

        Schema::drop('ms_ship');
    }
}
