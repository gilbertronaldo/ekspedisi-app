<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRecipientSenderAddPriceDocumentAndTagihDi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_recipient', function(Blueprint $table) {
            $table->integer('price_document')->nullable();
            $table->string('ambil_di', 10)->nullable();
        });
        Schema::table('ms_sender', function(Blueprint $table) {
            $table->integer('price_document')->nullable();
            $table->string('ambil_di', 10)->nullable();
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
            $table->dropColumn('price_document');
            $table->dropColumn('ambil_di');
        });
        Schema::table('ms_sender', function(Blueprint $table) {
            $table->dropColumn('price_document');
            $table->dropColumn('ambil_di');
        });
    }
}
