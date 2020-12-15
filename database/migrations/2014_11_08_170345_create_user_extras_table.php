<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_extras', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique();
            $table->ipAddress('login_ip')->nullable();
            $table->dateTime('login_at')->nullable();
            $table->unsignedInteger('login_num')->default(0)->nullable();
            $table->unsignedInteger('views')->default(0)->nullable();
            $table->unsignedInteger('articles')->default(0)->nullable();
            $table->unsignedInteger('downloads')->default(0)->nullable();
            $table->unsignedInteger('collections')->default(0)->nullable();
            $table->unsignedInteger('followers')->default(0)->nullable();//有多少粉丝
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_extras');
    }
}
