<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Database\Seeder;

class RepliesSeeder extends Seeder
{
    protected $length = 10; //假数据无限极分类的长度

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Reply::count() > 0) {
            return;
        }

        $user_ids = User::all()->pluck('id')->toArray();
        $post_ids = Post::find([1, 2])->pluck('id')->toArray();

        $reply = app(Reply::class);
        $leftColumnName = $reply->getLeftColumnName();
        $rightColumnName = $reply->getRightColumnName();
        $depthColumnName = $reply->getDepthColumnName();

        $replies = factory(Reply::class, 100)->make()->sortBy(function($post) {
            return $post->created_at;
        })->values()->each(function($reply, $key) use($user_ids, $post_ids, $leftColumnName, $rightColumnName, $depthColumnName) {
            $reply->user_id = array_random($user_ids);
            $reply->post_id = array_random($post_ids);

            //初始全部作为root
            $reply->$leftColumnName = ($key + 1) * 2 - 1;
            $reply->$rightColumnName = ($key + 1) * 2;
            $reply->$depthColumnName = 0;
        });

        DB::table('replies')->insert($replies->toArray());

        /*[
            post_id => [reply, reply, ...],
            post_id => [...],
            ...
        ]*/
        Reply::all()->groupBy('post_id')->each(function($group) {
            /*[
                [reply, reply, ...],
                [reply, reply, ...],
                ...
            ]*/
            $chunks = $group->chunk(intval(ceil($group->count() / $this->length))); //同一post_id的小组，分为$length队

            foreach($chunks as $chunk) {
                if ($chunk === $chunks->first()) { //第一组作为root
                    $paternities = $chunk;

                    continue;
                } else {
                    $chunk->each(function($reply) use($paternities) {
                        $reply->makeChildOf($paternities->random());
                    });

                    $paternities = $chunk;
                }
            }
        });
    }
}
