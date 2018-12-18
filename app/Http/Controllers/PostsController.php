<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Handlers\ImageUploader;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);

        $this->middleware('post.view_count', [
            'only' => ['show']
        ]);

        $this->middleware('permission:manage contents', [
            'only' => ['switchGood']
        ]);

        $this->middleware('unconfined', [
            'only' => ['create', 'store', 'edit', 'update']
        ]);
    }


    public function index(Request $request, User $user)
    {
        $posts = Post::withOrder($request->order)->paginate(30);

        $activists = $user->getActivists();

        return view('posts.index', compact('posts', 'activists'));
    }


    public function show(Post $post, Request $request)
    {
        //有slug的强制跳转slug链接
        if ($post->slug && $request->slug !== $post->slug) {
            return redirect()->to($post->link(), 301);
        }

        $replies = $post->replies()->recent()->get();

        return view('posts.show', compact('post', 'replies'));
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

        return redirect()->to($post->link())->with('success', '发布成功');
    }


    public function edit(Post $post)
    {
        $this->authorize('dominate', $post);

        $categories = Category::allFromCache();

        return view('posts.create_and_edit', compact('post', 'categories'));
    }


    public function update(Post $post, PostRequest $request)
    {
        $this->authorize('dominate', $post);

        $post->fill($request->all());
        $post->save();

        return redirect()->to($post->link())->with('success', '修改成功');
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


    public function imageStore(Request $request, ImageUploader $imageUploader)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,bmp,png,gif',
        ]);

        $result = $imageUploader->save($request->image, 'posts', Auth::id(), 1024, 1024);

        return $result ? [
            'success' => true,
            'msg' => '上传成功',
            'file_path' => $result['path'],
        ] : [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => '',
        ];
    }


    public function switchGood(Post $post)
    {
        switch ($post->is_good) {
            case false:
                $post->setGood();
                $message = '已加精';
                break;

            case true:
                $post->revokeGood();
                $message = '已取消精品';
                break;
        }

        return redirect()->back()->with('success', $message);
    }



}
