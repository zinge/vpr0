<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 30);
            $table->decimal('cost', 10, 2);

            if (Schema::hasColumn('finpositions', 'id')) {
              $table->integer('finposition_id');
              $table->foreign('finposition_id')
              ->references('id')
              ->on('finpositions');
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
        Schema::dropIfExists('services');
    }
}
