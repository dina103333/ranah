<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_price', function (Blueprint $table) {
            $table->id();
            $table->double('price');
            $table->unsignedBigInteger('store_id')->index();
            $table->unsignedBigInteger('expense_id')->index();
            $table->timestamps();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('expense_id')->references('id')->on('expenses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses_price');
    }
}
