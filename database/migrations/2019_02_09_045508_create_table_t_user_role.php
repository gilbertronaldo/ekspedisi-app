<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          't_user_role',
          function (Blueprint $table)
          {
              $table->bigIncrements('user_role_id');
              $table->bigInteger('user_id');
              $table->bigInteger('role_id');
              $table->string('city_code', 10);
              $table->timestamps();

              $table->foreign('user_id','t_user_role_user_id_fk')->references('id')->on('users');
              $table->foreign('role_id','t_user_role_role_id_fk')->references('role_id')->on('t_role');
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
        Schema::dropIfExists('t_user_role');
    }
}
