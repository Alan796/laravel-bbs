<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Requests\LikeRequest;

class LikesController extends Controller
{
    public function storeOrDestroy(LikeRequest $request)
    {
        $likable_type = modelFullName($request->likable_type);

        $likable = resolve($likable_type)->find($request->likable_id);

        if (Auth::user()->isAuthorOf($likable)) {
            $this->ajaxData['message'] = '不可给自己点赞';
            return $this->respondInAjax();
        }

        if ($like = $likable->likes()->where('user_id', Auth::id())->first()) {  //已点过赞
            $like->delete();
        } else {    //未点过赞
            $like = new Like;
            $like->user_id = Auth::id();
            $like->likable_id = $request->likable_id;
            $like->likable_type = $likable_type;
            $like->save();
        }

        $this->ajaxData['success'] = true;
        $this->ajaxData['data'] = ['count' => $like->likable->like_count];

        return $this->respondInAjax();
    }
}
