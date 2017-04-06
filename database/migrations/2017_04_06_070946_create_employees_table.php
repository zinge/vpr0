<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('employees', function (Blueprint $table) {
      $table->increments('id');

      $table->string('firstname', 30);
      $table->string('patronymic', 30)->nullable();
      $table->string('surname', 30);

      if (Schema::hasColumn('departments', 'id')) {
        $table->integer('department_id');
        $table->foreign('department_id')
        ->references('id')
        ->on('departments');
      }

      $table->enum('active', ['1', '0'])->default('1');

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
    Schema::dropIfExists('employees');
  }
}
