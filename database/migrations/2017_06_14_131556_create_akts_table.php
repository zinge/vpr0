<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAktsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 30);
            $table->date('billing_date');
            $table->integer('billing_month');

            // agreement_id
            if (Schema::hasColumn('agreements', 'id')) {
              $table->integer('agreement_id');
              $table->foreign('agreement_id')
              ->references('id')
              ->on('agreements');
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
        Schema::dropIfExists('akts');
    }
}
