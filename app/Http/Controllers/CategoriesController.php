<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Category;
use App\Post;

class CategoriesController extends Controller
{
    public function show(Request $request, Category $category, Tag $tag, Post $post)
    {
        $posts = $post->query()
            ->with('category')
            ->published()
            ->recently()
            ->where('category_id', $category->id)
            ->paginate(20);

        $tags = $tag->tagsList();
        $categories = $category->categoryList();
        $archives = $post->archiveList();

        return view('posts.index', compact('posts', 'category', 'tags', 'categories', 'archives'));
    }
}
