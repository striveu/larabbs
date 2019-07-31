<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id')->comment('主键');
            $table->string('name')->comment('姓名');
            $table->string('email')->unique()->comment('邮箱，用于登录');
            $table->timestamp('email_verified_at')->nullable()->comment('');
            $table->string('password')->comment('密码');
            $table->rememberToken()->comment('记住我 Token');
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
        Schema::dropIfExists('users');
    }
}
