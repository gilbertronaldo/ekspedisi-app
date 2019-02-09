1<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTableTTask
 */
class CreateTableTTask extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          't_task',
          function (Blueprint $table)
          {
              $table->bigIncrements('task_id');
              $table->string('task_code', 50);
              $table->string('task_name', 100);
              $table->string('task_description', 255)->nullable();
              $table->timestamps();
              $table->softDeletes();
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
        Schema::dropIfExists('t_task');
    }
}
