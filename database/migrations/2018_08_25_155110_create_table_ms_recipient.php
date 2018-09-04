<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMsRecipient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_recipient', function (Blueprint $table) {
            $table->bigIncrements('recipient_id');
            $table->string('recipient_code', 10);
            $table->string('recipient_name');
            $table->string('recipient_name_bapb')->nullable();
            $table->string('recipient_name_other')->nullable();
            $table->string('recipient_phone', 20);
            $table->text('recipient_address')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('price_ton')->nullable();
            $table->bigInteger('price_meter')->nullable();
            $table->bigInteger('minimum_charge')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id','ms_recipient_city_id_fk')->references('city_id')->on('ms_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_recipient', function (Blueprint $table) {
            $table->dropForeign('ms_recipient_city_id_fk');
        });

        Schema::drop('ms_recipient');
    }
}
