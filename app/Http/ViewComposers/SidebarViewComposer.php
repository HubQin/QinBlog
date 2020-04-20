<?php

namespace App\Http\ViewComposers;

use App\Category;
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
    protected $tags;
    protected $post;

    public function __construct(Category $category, Tag $tag, Post $post)
    {
        $this->category = $category;
        $this->tags = $tag;
        $this->post = $post;
    }

    public function compose(View $view)
    {
        $categories = $this->category->categoryList();
        $tags = $this->tags->tagsList();
        $archives = $this->post->archiveList();

        $view->with(compact('categories', 'tags', 'archives'));
    }
}
