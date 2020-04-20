<?php

namespace App\Providers;

use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;
use Vanry\Scout\Highlighter;
use Vanry\Scout\Tokenizers\JiebaTokenizer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 侧边栏数据
        view()->composer('posts.index', 'App\Http\ViewComposers\SidebarViewComposer');
        // 全文检索高亮实例
        view()->composer('posts.search', function ($view) {
            $view->with('highlighter', new Highlighter(new JiebaTokenizer()));
        });
    }
}
