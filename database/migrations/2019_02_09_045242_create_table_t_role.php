<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTRole extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          't_role',
          function (Blueprint $table)
          {
              $table->bigIncrements('role_id');
              $table->string('role_name', 20);
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
        Schema::dropIfExists('t_role');
    }
}
