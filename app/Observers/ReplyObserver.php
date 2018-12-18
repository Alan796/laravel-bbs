<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\PostReplied;
use App\Notifications\ReplyReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->post->increment('reply_count');

        if (empty($reply->reply_id)) {  //直接评论帖子
            if ($reply->user_id !== $reply->post->user_id) {    //评论的不是自己的帖子
                $reply->post->user->notify(new PostReplied($reply));    //通知帖子作者
            }
        } else {    //回复其他评论
            if ($reply->user_id !== $reply->parent->user_id) {  //回复的不是自己的评论
                $reply->parent->user->notify(new ReplyReplied($reply)); //通知被回复者
            }
        }
    }


    public function deleting(Reply $reply)
    {
        $reply->likes()->delete();
    }


    public function deleted(Reply $reply)
    {
        $reply->post->decrement('reply_count');
    }
}