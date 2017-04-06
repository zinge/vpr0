<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProneOwnersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('prone_owners', function (Blueprint $table) {
      $table->increments('id');

      if (Schema::hasColumn('phones', 'id')) {
        $table->integer('phone_id');
        $table->foreign('phone_id')
        ->references('id')
        ->on('phones');
      }
      if (Schema::hasColumn('employees', 'id')) {
        $table->integer('employee_id');
        $table->foreign('employee_id')
        ->references('id')
        ->on('employees');
      }
      
      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('prone_owners');
  }
}
