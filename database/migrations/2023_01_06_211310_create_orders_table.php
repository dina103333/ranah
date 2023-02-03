<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id')->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->float('sub_total');
            $table->float('total');
            $table->float('distance');
            $table->float('fee');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->float('discount_price')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('status',['معلق','جاري المعالجه','تم التأكيد','جاري التحضير','في الطريق','تم التسليم']);
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
        Schema::dropIfExists('orders');
    }
}
