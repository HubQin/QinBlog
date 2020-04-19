<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\Post;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function show(Request $request, Tag $tag, Category $category, Post $post)
    {
        $posts = $post->query()
            ->with('category')
            ->published()
            ->recently()
            ->whereHas('tags', function($q) use($tag){
                $q->where('tags.id', $tag->id);
            })
            ->paginate(20);

        $tags = $tag->tagsList();
        $categories = $category->categoryList();
        $archives = $post->archiveList();

        return view('posts.index', compact('posts', 'tag', 'categories', 'tags', 'archives'));
    }
}
