<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('标题');
            $table->text('body')->comment('内容');
            $table->integer('user_id')->unsigned()->index()->comment('作者id');
            $table->integer('category_id')->unsigned()->index()->comment('分类id');
            $table->boolean('is_good')->default(false)->comment('是否精品贴');
            $table->integer('view_count')->unsigned()->default(0)->comment('浏览数');
            $table->integer('like_count')->unsigned()->default(0)->comment('点赞数');
            $table->integer('dislike_count')->unsigned()->default(0)->comment('踩数');
            $table->integer('reply_count')->unsigned()->default(0)->comment('回复数');
            $table->integer('last_reply_user_id')->unsigned()->nullable()->comment('最后回复者id');
            $table->timestamp('last_reply_at')->nullable()->comment('最后回复于');
            $table->string('slug')->nullable()->comment('标题的英文翻译，用于SEO');
            $table->text('excerpt')->nullable()->comment('内容摘要');
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
        Schema::dropIfExists('posts');
    }
}
