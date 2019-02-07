<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterTableTrAddVerified
 */
class AlterTableTrAddVerified extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_bapb', function (Blueprint $table) {
            $table->boolean('verified')->default(FALSE);
        });

        Schema::table('tr_invoice', function (Blueprint $table) {
            $table->boolean('verified')->default(FALSE);
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
            $table->dropColumn('verified');
        });

        Schema::table('tr_invoice', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
    }
}
