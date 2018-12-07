<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name.' 的粉丝';

        return view('users.follows', compact('users', 'title'));
    }


    public function followees(User $user)
    {
        $users = $user->followees()->paginate(30);
        $title = $user->name.' 关注的人';

        return view('users.follows', compact('users', 'title'));
    }


    public function store(User $user)
    {
        if (Auth::id() === $user->id) {
            return response('不可关注自己', 404);
        }

        Auth::user()->follow($user->id);

        return redirect()->back()->with('success', '已关注该用户');
    }


    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return response('不可取关自己', 404);
        }

        Auth::user()->unfollow($user->id);

        return redirect()->back()->with('success', '已取关该用户');
    }
}
