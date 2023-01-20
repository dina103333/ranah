<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('quantity');
            $table->double('buy_price');
            $table->double('total');
            $table->date('production_date');
            $table->date('expiry_date');
            $table->timestamps();
            $table->foreign('receipt_id')->references('id')->on('receipts');
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
        Schema::dropIfExists('receipts_products');
    }
}
