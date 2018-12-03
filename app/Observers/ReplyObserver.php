<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->post->increment('reply_count');
    }


    public function deleted(Reply $reply)
    {
        $reply->post->decrement('reply_count');
    }
}