<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function saving(Post $post)
    {
        $post->body = parsedown($post->body);
        $post->body = clean($post->body, 'post_body');
        $post->excerpt = make_excerpt($post->body);
    }
}
