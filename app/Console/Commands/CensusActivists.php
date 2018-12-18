<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CensusActivists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bbs:census-activists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计活跃用户';

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

        app(User::class)->censusActivistsAndCache();

        $this->info('统计完成');
    }
}
