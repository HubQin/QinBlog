<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Category;
use App\Post;

class CategoriesController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $posts = Post::query()
            ->with('category')
            ->published()
            ->recently()
            ->where('category_id', $category->id)
            ->paginate(20);

        return view('posts.index', compact('posts', 'category'));
    }
}
