<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('departments', function (Blueprint $table) {
      $table->increments('id');

      if (Schema::hasColumn('addresses', 'id')) {
        $table->integer('address_id');
        $table->foreign('address_id')
        ->references('id')
        ->on('addresses');
      }

      $table->string('name', 100);

      //по умолчанию отдел активный
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
    Schema::dropIfExists('departments');
  }
}
