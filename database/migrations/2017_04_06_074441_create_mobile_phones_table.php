<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_phones', function (Blueprint $table) {
            $table->increments('id');

            $table->string('number', 30);

            if (Schema::hasColumn('mobile_types', 'id')) {
                $table->integer('mobile_type_id');
                $table->foreign('mobile_type_id')
                    ->references('id')
                    ->on('mobile_types');
            }

            if (Schema::hasColumn('mobile_limits', 'id')) {
                $table->integer('mobile_limit_id');
                $table->foreign('mobile_limit_id')
                    ->references('id')
                    ->on('mobile_limits');
            }

            if (Schema::hasColumn('employees', 'id')) {
              $table->integer('employee_id');
              $table->foreign('employee_id')
              ->references('id')
              ->on('employees');
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
        Schema::dropIfExists('mobile_phones');
    }
}
