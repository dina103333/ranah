<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCoulmInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mobile_number');
            $table->dropColumn('seconde_mobile_number');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_number')->unique()->after('name');
            $table->string('seconde_mobile_number')->unique()->nullable()->after('mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
