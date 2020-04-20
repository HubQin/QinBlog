<?php

namespace App\Http\Controllers;

use App\Category;
use App\Topic;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = Topic::with('posts.category')->get()->map(function($topic) {
            // 每个专题显示5条记录
            $topic->setRelation('posts', $topic->posts->take(5));
            return $topic;
        });
        return view('topics.index', compact('topics'));
}

    public function show(Request $request, Topic $topic)
    {
        $posts = Post::query()
            ->with('category')
            ->published()
            ->recently()
            ->where('topic_id', $topic->id)
            ->paginate(20);

        return view('posts.index', compact('posts', 'topic'));
    }
}
