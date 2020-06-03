<?php

namespace App\Providers;

use App\Services\IdentityIcon\IdentityIcon;
use Illuminate\Support\ServiceProvider;
use Parsedown;
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;

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

        $this->app->singleton(IdentityIcon::class, function (){
            return new IdentityIcon();
        });
        $this->app->alias(IdentityIcon::class, 'auto_avatar');

        $this->app->singleton(CopyWritingCorrectService::class, function() {
            return new CopyWritingCorrectService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 增加内存防止中文分词报错
         */
        ini_set('memory_limit', '1024M');


        \App\Post::observe(\App\Observers\PostObserver::class);
        \App\Comment::observe(\App\Observers\CommentObserver::class);
        \App\Column::observe(\App\Observers\ColumnObserver::class);
        \App\Link::observe(\App\Observers\LinkObserver::class);
    }
}
