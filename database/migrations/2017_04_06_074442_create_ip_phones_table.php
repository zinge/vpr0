<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpPhonesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('ip_phones', function (Blueprint $table) {
      $table->increments('id');

      $table->macAddress('macaddr');

      if (Schema::hasColumn('phones', 'id')) {
        $table->integer('phone_id');
        $table->foreign('phone_id')
        ->references('id')
        ->on('phones');
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
    Schema::dropIfExists('ip_phones');
  }
}
