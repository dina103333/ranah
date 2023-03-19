<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('store_id');
            $table->double('item_value')->nullable();
            $table->double('item_ratio')->nullable();
            $table->double('wholesale_value')->nullable();
            $table->double('wholesale_ratio')->nullable();
            $table->double('from_item_total')->nullable();
            $table->double('to_item_total')->nullable();
            $table->double('from_wholesale_total')->nullable();
            $table->double('to_wholesale_total')->nullable();
            $table->enum('status',['تفعيل','ايقاف']);
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
        Schema::dropIfExists('discount_products');
    }
}
