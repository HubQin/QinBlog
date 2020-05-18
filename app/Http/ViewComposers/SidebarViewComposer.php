<?php

namespace App\Http\ViewComposers;

use App\Category;
use App\Link;
use App\Post;
use App\Tag;
use Illuminate\View\View;

/**
 * 侧边栏数据
 * Class SidebarComposer
 * @package App\Http\ViewComposers
 */
class SidebarViewComposer
{
    protected $category;
    protected $tag;
    protected $post;

    public function __construct(Category $category, Tag $tag, Post $post)
    {
        $this->category = $category;
        $this->tag = $tag;
        $this->post = $post;
    }

    public function compose(View $view)
    {
        $categories = cache()->rememberForever('categories', function (){
            return $this->category->categoryList();
        });
        $tags = cache()->rememberForever('tags', function (){
            return $this->tag->tagsList();
        });
        $archives = cache()->rememberForever('archives', function (){
            return $this->post->archiveList();
        });
        $links = cache()->rememberForever('links', function () {
            return Link::where('status', 1)->orderBy('sort')->get();
        });

        $view->with(compact('categories', 'tags', 'archives', 'links'));
    }
}
