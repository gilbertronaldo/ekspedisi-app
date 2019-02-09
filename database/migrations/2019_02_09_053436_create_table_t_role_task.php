<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTRoleTask extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          't_role_task',
          function (Blueprint $table)
          {
              $table->bigIncrements('role_task_id');
              $table->bigInteger('role_id');
              $table->bigInteger('task_id');
              $table->timestamps();

              $table->foreign('role_id', 't_role_task_role_id_fk')->references(
                'role_id'
              )->on('t_role');
              $table->foreign('task_id', 't_role_task_task_id_fk')->references(
                'task_id'
              )->on('t_task');
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
        Schema::dropIfExists('t_role_task');
    }
}
