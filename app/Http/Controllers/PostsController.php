<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function index(Request $request, Post $post)
    {
        $posts = $post->with('category')->paginate(20);
        $links = [];
        return view('posts.index', compact('posts', 'links'));
    }
}
