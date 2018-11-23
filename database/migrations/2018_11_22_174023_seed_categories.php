<?php

use Illuminate\Database\Migrations\Migration;

class SeedCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            [
                'name' => '分享',
                'description' => '分享心得，共同学习',
            ],
            [
                'name' => '教程',
                'description' => '不断给自己充电',
            ],
            [
                'name' => '公告',
                'description' => '从这里了解社区最新动态',
            ],
            [
                'name' => '招聘',
                'description' => '求职者和求贤者看过来！',
            ],
        ];

        DB::table('categories')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
