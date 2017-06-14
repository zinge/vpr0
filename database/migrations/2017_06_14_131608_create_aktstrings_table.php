<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktstringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktstrings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('physical');
            $table->decimal('summ_cost', 10, 2);

            // service_id
            if (Schema::hasColumn('services', 'id')) {
              $table->integer('service_id');
              $table->foreign('service_id')
              ->references('id')
              ->on('services');
            }

            // akt_id
            if (Schema::hasColumn('akts', 'id')) {
              $table->integer('akt_id');
              $table->foreign('akt_id')
              ->references('id')
              ->on('akts');
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
        Schema::dropIfExists('aktstrings');
    }
}
