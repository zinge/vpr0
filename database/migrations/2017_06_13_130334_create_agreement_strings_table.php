<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementStringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_strings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('physical')->nullable();
            $table->decimal('summ_cost', 10, 2)->nullable();

            // agreement_id
            if (Schema::hasColumn('agreements', 'id')) {
              $table->integer('agreement_id');
              $table->foreign('agreement_id')
              ->references('id')
              ->on('agreements');
            }

            // service_id
            if (Schema::hasColumn('services', 'id')) {
              $table->integer('service_id');
              $table->foreign('service_id')
              ->references('id')
              ->on('services');
            }

            // department_id
            if (Schema::hasColumn('departments', 'id')) {
              $table->integer('department_id');
              $table->foreign('department_id')
              ->references('id')
              ->on('departments');
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
        Schema::dropIfExists('agreement_strings');
    }
}
