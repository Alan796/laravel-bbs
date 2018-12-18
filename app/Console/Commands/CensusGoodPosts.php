<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class CensusGoodPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bbs:census-good-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计精品帖';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('开始统计');

        app(Post::class)->censusGoodPosts();

        $this->info('统计完成');
    }
}
