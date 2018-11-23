<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);
    }


    public function index(Request $request)
    {
        $posts = Post::withOrder($request->order)->paginate(30);

        return view('posts.index', compact('posts'));
    }


    public function show()
    {

    }


    public function create(Post $post)
    {
        $categories = Category::allFromCache();

        return view('posts.create_and_edit', compact('post', 'categories'));
    }


    public function store(PostRequest $request, Post $post)
    {
        $post->fill($request->all());
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', '发布成功');
    }


    public function edit(Post $post)
    {
        $this->authorize('dominate', $post);

        //TODO
    }


    public function update(Post $post)
    {
        $this->authorize('dominate', $post);

        //TODO

    }


    public function destroy(Post $post)
    {
        $this->authorize('dominate', $post);

        if ($post->is_good) {
            return redirect()->back()->with('error', '精品帖不可删除');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', '帖子已删除');
    }
}
