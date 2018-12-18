<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use App\Notifications\Followed;
use App\Notifications\Register;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, Traits\Activist;

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


    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id')
            ->withTimestamps();
    }


    public function followees()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id')
            ->withTimestamps();
    }


    public function confinements()
    {
        return $this->hasMany(Confinement::class);
    }


    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $user_ids = array_diff($user_ids, [$this->id]);   //不可关注自己

        $followee_ids = $this->followees()->syncWithoutDetaching($user_ids)['attached'];    //被关注的用户id数组

        $this->increment('followee_count', count($followee_ids));   //关注者增加关注数量

        //遍历每个被关注者
        foreach($followee_ids as $followee_id) {
            $follow = Follow::where('follower_id', $this->id)->where('followee_id', $followee_id)->first();   //follow实例

            $followee = self::find($followee_id);   //被关注者实例
            $followee->increment('follower_count');  //被关注者增加粉丝数量
            $followee->notify(new Followed($follow));   //通知被关注者
        }
    }


    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $user_ids = array_diff($user_ids, [$this->id]);   //不可取关自己

        $unfollowCount = 0; //取关数量
        foreach($user_ids as $user_id) {
            $result = $this->followees()->detach($user_id);

            if ($result === 1) {
                self::find($user_id)->decrement('follower_count');
                ++$unfollowCount;
            }
        }
        $this->decrement('followee_count', $unfollowCount);
    }


    public function isFollowing($user_id)
    {
        return $this->followees->contains($user_id);
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


    public function markAsRead()
    {
        $this->unreadNotifications->markAsRead();
        $this->notification_count = 0;
        $this->save();
    }


    public function isConfined()
    {
        return $this->confinements()->effective()->count() > 0;
    }


    public function confine($is_permanent = true, Carbon $expired_at = null)
    {
        //要么永久禁言，要么短暂禁言（提供一个终止时间）
        if (!$is_permanent && $expired_at === null) {
            return;
        }

        $confinement = $this->confinements()->effective()->first() ? : new Confinement;
        $confinement->user_id = $this->id;
        $confinement->is_permanent = $is_permanent;
        $confinement->confined_by = Auth::id();
        $confinement->confined_at = now()->toDateTimeString();
        $confinement->expired_at = $expired_at ? $expired_at->toDateTimeString() : null;
        $confinement->save();
    }


    public function release()
    {
        if (empty($confinement = $this->confinements()->effective()->first())) {
            return;
        }

        $confinement->is_abolished = true;
        $confinement->abolished_by = Auth::id();
        $confinement->save();
    }
}
