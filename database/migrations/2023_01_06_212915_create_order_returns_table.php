<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('shop_id')->index();
            $table->unsignedBigInteger('product_id');
            $table->float('unit_quantity');
            $table->float('wholesale_quantity');
            $table->float('unit_price');
            $table->float('wholesale_price');
            $table->float('total');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('updated_by');
            $table->enum('status',['تم الاستلام','قيد الانتظار'])->default('قيد الانتظار');
            $table->timestamps();
            $table->foreign('shop_id')->references('id')->on('shopes');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_returns');
    }
}
