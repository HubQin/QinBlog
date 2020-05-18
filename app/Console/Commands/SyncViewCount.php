<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;

class SyncViewCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:sync-view-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步文章浏览量';

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
    public function handle(Post $post)
    {
        $post->syncYesterdayViewCount();
        $this->info('同步成功');
    }
}
