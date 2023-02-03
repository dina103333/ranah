<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->index();
            $table->unsignedBigInteger('product_id');
            $table->float('wholesale_quantity');
            $table->float('unit_quantity');
            $table->float('wholesale_price');
            $table->float('wholesale_total');
            $table->float('unit_total');
            $table->timestamps();
            $table->foreign('cart_id')->references('id')->on('carts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_products');
    }
}
