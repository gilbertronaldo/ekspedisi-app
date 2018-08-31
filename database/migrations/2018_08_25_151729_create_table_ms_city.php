<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMsCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_city', function (Blueprint $table) {
            $table->bigIncrements('city_id');
            $table->bigInteger('country_id');
            $table->string('city_code', 10);
            $table->string('city_name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id','ms_city_country_id_fk')->references('country_id')->on('ms_country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_city', function (Blueprint $table) {
            $table->dropForeign('ms_city_country_id_fk');
        });

        Schema::drop('ms_city');
    }
}
