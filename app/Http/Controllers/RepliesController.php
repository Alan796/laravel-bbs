<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show']
        ]);
    }


    public function show(Reply $reply)
    {
        $replies = $reply->ancestorsAndSelf()->with('user')->get();
        $post = $reply->post;

        return view('replies.show', compact('replies', 'post'));
    }


    public function store(Reply $reply, ReplyRequest $request)
    {
        $reply->fill($request->all());
        $reply->user_id = Auth::id();
        $reply->save();

        return redirect()->to($reply->post->link())->with('success', '回复成功');
    }


    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);

        $post = $reply->post;
        $reply->delete();

        return redirect()->to($post->link())->with('success', '已删除回复');
    }
}
