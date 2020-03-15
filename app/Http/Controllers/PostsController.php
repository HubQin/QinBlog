<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\Topic;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::query()->with('category')->published()->recently()->paginate(20);
        $links = [];
        return view('posts.index', compact('posts', 'links'));
    }

    public function create(Post $post)
    {
        $categories = Category::all(['id', 'name', 'icon'])->toArray();
        $topics = Topic::all();
        $tags = Tag::all(['id', 'name'])->toArray();

        return view('posts.create_and_edit', compact('post', 'categories', 'topics', 'tags'));
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->only(['title', 'category_id', 'body']);
        $post->fill($data);
        $post->user_id = \Auth::id();
        $post->save();

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
