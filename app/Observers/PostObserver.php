<?php

namespace App\Observers;

use App\Models\Post;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class PostObserver
{
    public function created(Post $post)
    {
        $post->category->increment('post_count');
    }


    public function saving(Post $post)
    {
        if (!$post->slug || $post->isDirty('title')) {
            $post->slug = 'I am slug';  //TODO
        }

        $post->excerpt = makeExcerpt($post->body);
    }


    public function deleted(Post $post)
    {
        $post->category->decrement('post_count');
    }
}