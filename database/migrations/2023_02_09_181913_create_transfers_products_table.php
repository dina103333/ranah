<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfers_id');
            $table->unsignedBigInteger('product_id');
            $table->float('wholesale_quantity');
            $table->float('unit_quantity');
            $table->timestamps();
            $table->foreign('transfers_id')->references('id')->on('transfers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers_products');
    }
}
