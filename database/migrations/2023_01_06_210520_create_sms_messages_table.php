<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_admin_id')->index();
            $table->unsignedBigInteger('to_user_id')->index();
            $table->string('message');
            $table->timestamps();
            $table->foreign('from_admin_id')->references('id')->on('admins');
            $table->foreign('to_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_messages');
    }
}
