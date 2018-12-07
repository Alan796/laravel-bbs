<?php

namespace App\Observers;

use App\Models\Post;
use App\Jobs\TranslateSlug;
use App\Notifications\PostCreated;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class PostObserver
{
    public function created(Post $post)
    {
        $post->category->increment('post_count');

        if ($followers = $post->user->followers) {
            $followers->each(function($follower) use($post) {
                $follower->notify(new PostCreated($post));
            });
        }
    }


    public function saving(Post $post)
    {
        $post->body = clean($post->body);
        $post->excerpt = makeExcerpt($post->body);
    }


    public function saved(Post $post)
    {
        if (!$post->slug || $post->isDirty('title')) {
            dispatch(new TranslateSlug($post));
        }
    }


    public function deleted(Post $post)
    {
        $post->category->decrement('post_count');
    }
}