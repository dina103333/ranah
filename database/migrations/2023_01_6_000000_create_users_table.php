<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('mobile_number')->unique();
            $table->integer('seconde_mobile_number')->unique()->nullable();
            $table->string('password');
            $table->integer('otp')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->unsignedBigInteger('seller_id')->index()->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->enum('type',['اونلاين','مباشر'])->default('اونلاين');
            $table->enum('status',['تفعيل','حظر'])->default('تفعيل');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('sellers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
