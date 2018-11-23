<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'category_id'];

    protected $dates = ['last_replied_at', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function last_replier()
    {
        return $this->belongsTo(User::class, 'last_reply_user_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     *
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent_publish':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        return $query->with(['user', 'category', 'last_replier']);
    }


    /**
     * 最近发布
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }


    /**
     * 最近被回复
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('last_replied_at', 'desc');
    }
}
