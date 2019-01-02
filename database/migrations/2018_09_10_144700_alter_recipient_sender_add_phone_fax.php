<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRecipientSenderAddPhoneFax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_recipient', function(Blueprint $table) {
            $table->string('recipient_telephone')->nullable();
            $table->string('recipient_fax')->nullable();
        });
        Schema::table('ms_sender', function(Blueprint $table) {
            $table->string('sender_telephone')->nullable();
            $table->string('sender_fax')->nullable();
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
            $table->dropColumn('recipient_telephone');
            $table->dropColumn('recipient_fax');
        });

        Schema::table('ms_sender', function(Blueprint $table) {
            $table->dropColumn('sender_telephone');
            $table->dropColumn('sender_fax');
        });
    }
}
