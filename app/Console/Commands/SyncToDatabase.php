<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;

class SyncToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bbs:sync-to-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将缓存数据同步至数据库';

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
        $this->info('开始同步');

        app(Post::class)->syncCacheToDatabase();
        app(User::class)->syncLastActiveAtCacheToDatabase();

        $this->info('同步完成');
    }
}
