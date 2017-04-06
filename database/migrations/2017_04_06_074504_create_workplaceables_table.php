<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkplaceablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workplaceables', function (Blueprint $table) {
            $table->increments('id');

            if (Schema::hasColumn('workplaces', 'id')) {
                $table->integer('workplace_id');
                $table->foreign('workplace_id')
                    ->references('id')
                    ->on('workplaces');
            }

            $table->morphs('workplaceable');

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
        Schema::dropIfExists('workplaceables');
    }
}
