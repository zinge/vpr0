<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');

            // связь с таблицей phone_types
            if (Schema::hasColumn('phone_types', 'id')) {
                $table->integer('phone_type_id');
                $table->foreign('phone_type_id')
                    ->references('id')
                    ->on('phone_types');
            }

            //можно цифры, но лучше строки, 30 для номера, возможны скобки и +
            //(+78553254)312-30-24#3715
            $table->string('number', 30);

            //по умолчанию номер активный
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
        Schema::dropIfExists('phones');
    }
}
