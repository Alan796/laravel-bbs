<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body')->comment('回复内容');
            $table->integer('user_id')->unsigned()->index()->comment('回复者');
            $table->integer('post_id')->unsigned()->index()->comment('回复哪个帖子');
            $table->integer('reply_id')->unsigned()->nullable()->index()->comment('回复哪个回复(etrepat/baum:parent_id)');
            $table->integer('left_id')->nullable()->comment('(etrepat/baum:lft)');
            $table->integer('right_id')->nullable()->comment('(etrepat/baum:rgt)');
            $table->integer('depth')->nullable()->comment('(etrepat/baum:depth)');
            $table->integer('like_count')->unsigned()->default(0)->comment('点赞数');
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
        Schema::dropIfExists('replies');
    }
}
