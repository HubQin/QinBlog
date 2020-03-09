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
        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(20);
        $links = [];
        return view('posts.index', compact('posts', 'links'));
    }

    public function create(Post $post)
    {
        $categories = Category::all();
        $topics = Topic::all();
        $tags = Tag::all();

        return view('posts.create_and_edit', compact('post', 'categories', 'topics', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['title', 'category_id', 'body']);
        $request->user()->posts()->create($data);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
