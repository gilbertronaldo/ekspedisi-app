<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRecipientSenderAddColumnEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_recipient', function(Blueprint $table) {
            $table->string('recipient_code')->change();
            $table->string('email')->nullable();
        });
        Schema::table('ms_sender', function(Blueprint $table) {
            $table->string('sender_code')->change();
            $table->string('sender_code')->change();
            $table->string('email')->nullable();
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
            $table->dropColumn('email');
        });

        Schema::table('ms_sender', function(Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
