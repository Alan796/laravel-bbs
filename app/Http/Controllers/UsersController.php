<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Handlers\ImageUploader;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['store']
        ]);
        $this->middleware('auth', [
            'only' => ['edit', 'update']
        ]);
    }

    public function show(User $user)
    {
        $posts = $user->posts()->recent()->paginate(5);

        return view('users.show', compact('user', 'posts'));
    }


    public function create()
    {
        return view('users.create');
    }


    public function getValidateEmail(User $user, Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|unique:users',
        ]);

        $token = md5(time().'_'.str_random(8));
        $expireAt = now()->addMinute(30);

        \Cache::put($token, ['email' => $request->email], $expireAt);

        $user->sendRegisterNotification($token, $request->email, $expireAt);

        session()->flash('success', '邮件已发送，请登陆邮箱验证');

        return redirect('/');
    }


    public function validateEmail($token, $email)
    {
        if (!$cacheData = \Cache::get($token)) {
            return $this->responseWithMessage('danger', '验证已过期');
        }

        if (!hash_equals($cacheData['email'], $email)) {
            return $this->responseWithMessage('danger', '验证错误');
        }

        return view('users.complete_info', ['token' => $token, 'email' => $cacheData['email']]);
    }


    public function store(UserRequest $request)
    {
        if (!$cacheData = \Cache::get($request->token)) {
            return $this->responseWithMessage('danger', '验证已过期');
        }

        if (!hash_equals($cacheData['email'], $request->email)) {
            return $this->responseWithMessage('danger', '验证错误');
        }

        \Cache::forget($request->token);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        \Auth::login($user);

        return $this->responseWithMessage('success', '注册成功');
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }


    public function update(User $user, UserRequest $request, ImageUploader $imageUploader)
    {
        $this->authorize('update', $user);

        $user->fill($request->except(['email', 'avatar']));

        if ($request->avatar) {
            if ($result = $imageUploader->save($request->avatar, 'avatars', $user->id, 362, 362)) {
                $user->avatar = $result['path'];
            }
        }

        $user->save();

        return redirect()->route('users.show', $user->id);
    }
}
