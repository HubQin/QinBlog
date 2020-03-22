<?php

namespace App\Jobs;

use App\Post;
use App\Services\PostService;
use App\Services\TranslateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post)
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
        // 翻译
        $translatedText = app(TranslateService::class)->translate($this->post->title);
        // 生成Slug
        app(PostService::class)->creatUniqueSlug($this->post, $translatedText);
        // 保存
        \DB::table('posts')->where('id', $this->post->id)->update(['slug' => $this->post->slug]);
    }
}
