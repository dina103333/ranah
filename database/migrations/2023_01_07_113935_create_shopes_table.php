<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name');
            $table->string('address')->nullable();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('shop_types_id')->index();
            $table->unsignedBigInteger('car_id')->index()->nullable();
            $table->unsignedBigInteger('area_id')->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shop_types_id')->references('id')->on('shope_types')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars');
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
        Schema::dropIfExists('shopes');
    }
}
