<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $category_ids = Category::all()->pluck('id')->toArray();

        $posts = factory(Post::class, 200)->make()->sortBy(function($post, $key) {
            return $post->created_at;
        })->each(function($post) use($user_ids, $category_ids) {
            $post->user_id = array_random($user_ids);
            $post->category_id = array_random($category_ids);
        });

        DB::table('posts')->insert($posts->toArray());
    }
}
