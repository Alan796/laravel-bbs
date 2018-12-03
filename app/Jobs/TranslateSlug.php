<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Handlers\SlugTranslator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slug = app(SlugTranslator::class)->translate($this->post->title);

        //避免与路由冲突
        if ($slug === 'edit') {
            $slug = 'compile';
        }

        \DB::table('posts')->where('id', $this->post->id)->update(['slug' => $slug]);
    }
}
