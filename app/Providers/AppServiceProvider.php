<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Parsedown;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Parsedown::class, function() {
            return Parsedown::instance()->setSafeMode(true);
        });
        $this->app->alias(Parsedown::class, 'parsedown');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Post::observe(\App\Observers\PostObserver::class);
        \App\Comment::observe(\App\Observers\CommentObserver::class);
    }
}
