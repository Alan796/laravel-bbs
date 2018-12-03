<?php

namespace App\Models;

use App\Notifications\Register;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'introduction', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }


    public function followees()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }


    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $user_ids = array_diff($user_ids, [$this->id]);   //不可关注自己

        $this->followees()->syncWithoutDetaching($user_ids);
    }


    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $user_ids = array_diff($user_ids, [$this->id]);   //不可取关自己

        $this->followees()->detach($user_ids);
    }


    public function isFollowing($user_id)
    {
        return $this->followees()->contains($user_id);
    }


    public function sendRegisterNotification($token, $email, $expireAt)
    {
        $this->fill(['email' => $email])->notify(new Register($token, $email, $expireAt));
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    public function isAuthorOf($model, $column = 'user_id')
    {
        return $this->id === $model->$column;
    }
}
