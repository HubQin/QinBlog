<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Post;

class PostObserver
{
    public function saving(Post $post)
    {
        $post->body = parsedown($post->body);
        $post->body = clean($post->body, 'post_body');
        $post->excerpt = make_excerpt($post->body);
    }

    public function saved(Post $post)
    {
        // 如果没有slug，使用文章标题翻译并转化成slug
        if (empty($post->slug)) {
            dispatch(new TranslateSlug($post));
        }
    }

    public function created()
    {
        // 更新标签文章数

        // 更新分类文章数
    }
}
