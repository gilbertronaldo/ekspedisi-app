<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRecipientSenderAddMinimumChargeCalculation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_recipient', function(Blueprint $table) {
            $table->integer('minimum_charge_calculation_id')->nullable();
        });
        Schema::table('ms_sender', function(Blueprint $table) {
            $table->integer('minimum_charge_calculation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_recipient', function(Blueprint $table) {
            $table->dropColumn('minimum_charge_calculation_id');
        });
        Schema::table('ms_sender', function(Blueprint $table) {
            $table->dropColumn('minimum_charge_calculation_id');
        });
    }
}
