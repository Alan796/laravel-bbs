<?php

namespace App\Observers;

use App\Models\Like;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class LikeObserver
{
    public function created(Like $like)
    {
        $like->likable->increment('like_count');
    }


    public function deleted(Like $like)
    {
        $like->likable->decrement('like_count');
    }
}