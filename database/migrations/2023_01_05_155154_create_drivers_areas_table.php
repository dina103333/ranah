<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id')->index();
            $table->unsignedBigInteger('area_id')->index();
            $table->timestamps();
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers_areas');
    }
}
