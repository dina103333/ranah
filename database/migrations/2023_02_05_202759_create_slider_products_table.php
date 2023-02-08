<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slider_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->timestamps();
            $table->foreign('slider_id')->references('id')->on('sliders');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_products');
    }
}
