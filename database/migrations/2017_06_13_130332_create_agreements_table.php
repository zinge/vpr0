<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 30);
            $table->date('initial_date');
            $table->date('end_date');

            if (Schema::hasColumn('contractors', 'id')) {
              $table->integer('contractor_id');
              $table->foreign('contractor_id')
              ->references('id')
              ->on('contractors');
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
        Schema::dropIfExists('agreements');
    }
}
