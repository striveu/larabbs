<?php

/*
 * This file is part of the lucifer103/larabbs.
 *
 * (c) Lucifer <luciferi103@outlook.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('topic_id')->unsigned()->default(0)->index()->comment('话题 ID');
            $table->bigInteger('user_id')->unsigned()->default(0)->index()->comment('用户 ID');
            $table->text('content')->comment('评论内容');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('replies');
    }
}
