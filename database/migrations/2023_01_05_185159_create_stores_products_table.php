<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->double('sell_wholesale_price');
            $table->double('sell_item_price');
            $table->integer('wholesale_quantity');
            $table->integer('unit_quantity');
            $table->integer('lower_limit')->default(0);
            $table->integer('max_limit')->default(0);
            $table->integer('first_period')->default(0);
            $table->integer('reorder_limit')->default(0);
            $table->float('buy_price')->default(0.00);
            $table->double('unit_gain_ratio')->default(0.00);
            $table->double('wholesale_gain_ratio')->default(0.00);
            $table->double('wholesale_gain_value')->default(0.00);
            $table->double('unit_gain_value')->default(0.00);
            $table->double('loss')->default(0.00);
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores');
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
        Schema::dropIfExists('stores_products');
    }
}
