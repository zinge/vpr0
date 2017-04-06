<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileTypesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('mobile_types', function (Blueprint $table) {
      $table->increments('id');

      //изначально, передача данных или голос, можно enum('name', ['голос', 'данные'])
      $table->string('name', 30);

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
    Schema::dropIfExists('mobile_types');
  }
}
