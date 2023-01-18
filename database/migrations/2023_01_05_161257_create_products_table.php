<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('company_id')->index();
            $table->string('wholesale_type');
            $table->string('item_type');
            $table->integer('wholesale_quantity_units');
            $table->enum('discount',['نسبه','كاش'])->nullable();
            $table->enum('wating',['نعم','لا']);
            $table->integer('wholesale_max_quantity');
            $table->enum('status',['تفعيل','ايقاف'])->default('تفعيل');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
}
