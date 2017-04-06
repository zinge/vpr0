<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('addresses', function (Blueprint $table) {
      $table->increments('id');
      $table->string('city', 30);
      $table->string('street', 100);
      $table->string('house', 10);

      //по умолчанию адрес активный
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
    Schema::dropIfExists('addresses');
  }
}
