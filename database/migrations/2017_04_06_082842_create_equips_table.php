<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
    public function up()
    {
        Schema::create('equips', function (Blueprint $table) {
            $table->increments('id');

          //может неожиданно отличаться от вендора
            $table->string('name')->nullable();

            if (Schema::hasColumn('manufacturers', 'id')) {
                $table->integer('manufacturer_id');
                $table->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers');
            }

            if (Schema::hasColumn('holders', 'id')) {
                $table->integer('holder_id');
                $table->foreign('holder_id')
                ->references('id')
                ->on('holders');
            }

            if (Schema::hasColumn('equip_types', 'id')) {
                $table->integer('equip_type_id');
                $table->foreign('equip_type_id')
                ->references('id')
                ->on('equip_types');
            }

            if (Schema::hasColumn('equip_models', 'id')) {
                $table->integer('equip_model_id');
                $table->foreign('equip_model_id')
                ->references('id')
                ->on('equip_models');
            }

            if (Schema::hasColumn('employees', 'id')) {
                $table->integer('employee_id');
                $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            }

          //дата ввода в эксплуатацию
            $table->date('initial_date')->nullable();

          //балансовая стоимость
            $table->decimal('initial_cost', 10, 2)->nullable();

          //серийный номер, по бухгалтерии
            $table->string('serial_number', 50)->nullable();

          //если в сапе другой, то его тоже
            $table->string('sap_number', 50)->nullable();

          //заводской номер
            $table->string('manufacturer_number', 50)->nullable();

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
        Schema::dropIfExists('equips');
    }
}
