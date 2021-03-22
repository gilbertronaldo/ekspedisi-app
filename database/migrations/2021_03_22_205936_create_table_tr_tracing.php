<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrTracing extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tr_tracing',
            function (Blueprint $table) {
                $table->bigIncrements('tracing_id');
                $table->bigInteger('bapb_id')->nullable();
                $table->bigInteger('recipient_id');
                $table->string('no_container_1', 191)->nullable();
                $table->string('no_container_2', 191)->nullable();

                $table->string('name')->nullable();
                $table->timestamp('tanggal_terima')->nullable();
                $table->float('koli', 0)->nullable();
                $table->text('description')->nullable();
                $table->json('attachments')->nullable()->default('[]');

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('bapb_id', 'tr_tracing_bapb_id_fk')->references(
                    'bapb_id'
                )->on('tr_bapb');
                $table->foreign('recipient_id', 'tr_tracing_recipient_id_fk')->references(
                    'recipient_id'
                )->on('ms_recipient');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_tracing');
    }
}
