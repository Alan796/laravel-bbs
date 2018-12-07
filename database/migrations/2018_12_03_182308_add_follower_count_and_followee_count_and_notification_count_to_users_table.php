<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFollowerCountAndFolloweeCountAndNotificationCountToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('follower_count')->unsigned()->default(0)->comment('粉丝数量');
            $table->integer('followee_count')->unsigned()->default(0)->comment('关注的用户数');
            $table->integer('notification_count')->unsigned()->default(0)->comment('通知数');
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
            $table->dropColumn(['follower_count', 'followee_count', 'notification_count']);
        });
    }
}
