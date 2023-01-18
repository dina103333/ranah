<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('finance')->nullable();
            $table->unsignedBigInteger('area_id')->index();
            $table->unsignedBigInteger('store_keeper_id')->nullable();
            $table->unsignedBigInteger('store_finance_manager_id')->nullable();
            $table->unsignedBigInteger('accountant_id')->nullable();
            $table->string('address');
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
