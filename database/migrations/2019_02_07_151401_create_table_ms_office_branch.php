<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTableMsOfficeBranch
 */
class CreateTableMsOfficeBranch extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
          'ms_office_branch',
          function (Blueprint $table)
          {
              $table->increments('office_branch_id');
              $table->string('office_branch_name', '100');
              $table->bigInteger('city_id')->nullable();
              $table->string('bank_account', '50');
              $table->string('bank_account_name', '255');
              $table->string('bank_account_number', '100');
              $table->timestamps();
              $table->softDeletes();

              $table->foreign('city_id', 'ms_recipient_city_id_fk')
                    ->references(
                      'city_id'
                    )->on('ms_city');
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
        Schema::dropIfExists('ms_office_branch');
    }
}
