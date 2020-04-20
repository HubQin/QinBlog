<?php

namespace App\Providers;

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
        view()->composer('posts.search', function ($view) {
            $view->with('highlighter', new Highlighter(new JiebaTokenizer()));
        });
    }
}
