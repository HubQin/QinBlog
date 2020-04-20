<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\Post;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function show(Request $request, Tag $tag)
    {
        $posts = Post::query()
            ->with('category')
            ->published()
            ->recently()
            ->whereHas('tags', function($q) use($tag){
                $q->where('tags.id', $tag->id);
            })
            ->paginate(20);

        return view('posts.index', compact('posts', 'tag'));
    }
}
