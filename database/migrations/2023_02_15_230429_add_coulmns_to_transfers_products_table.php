<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoulmnsToTransfersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers_products', function (Blueprint $table) {
            $table->date('production_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->float('buy_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers_products', function (Blueprint $table) {
            //
        });
    }
}
