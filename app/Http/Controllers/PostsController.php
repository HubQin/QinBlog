<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use App\Tag;
use App\Topic;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $posts = Post::query()->with('category')->published()->recently()->paginate(20);
        $links = [];
        return view('posts.index', compact('posts', 'links'));
    }

    public function create(Post $post)
    {
        $categories = Category::all(['id', 'name', 'icon'])->toArray();
        $topics = Topic::all(['id', 'name'])->toArray();
        $tags = Tag::all(['id', 'name'])->toArray();

        return view('posts.create_and_edit', compact('post', 'categories', 'topics', 'tags'));
    }

    public function store(PostRequest $request, Post $post, PostService $postService)
    {
        $data = $request->only(['title', 'body', 'category_id']);
        $post->fill($data);
        $post->user_id = \Auth::id();

        // 如果有填写slug字段，创建一个唯一的以“-”连接的Slug
        if ($slug = $request->slug) {
            $postService->creatUniqueSlug($post, $slug);
        }

        // 保存文章以及标签、专题信息
        $result = $postService->store($request, $post);

        if ($result instanceof Post) {
            return redirect()->to($post->link())->with('success', '发布成功');
        } else {
            return redirect()->back()->withErrors(['error' => $result->getMessage()]);
        }
    }

    public function show(Post $post, Request $request)
    {
        if (! empty($post->slug) && $post->slug != $request->slug) {
            return redirect()->to($post->link(), 301);
        }

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('own', $post);

        $categories = Category::all(['id', 'name', 'icon'])->toArray();
        $topics = Topic::all(['id', 'name'])->toArray();
        $tags = Tag::all(['id', 'name'])->toArray();

        $post->body = html_to_markdown($post->body);

        return view('posts.create_and_edit', compact('post', 'categories', 'topics', 'tags'));
    }

    public function update(Post $post, PostRequest $request, PostService $postService)
    {
        $this->authorize('own', $post);

        $data = $request->only(['title', 'body', 'category_id']);
        $post->fill($data);

        // 如果有填写slug字段，且Slug已修改，创建一个唯一的以“-”连接的Slug
        if ($slug = $request->slug && $request->slug != $post->slug) {
            $postService->creatUniqueSlug($post, $slug);
        }

        // 保存文章以及标签、专题信息
        $result = $postService->update($request, $post);

        if ($result instanceof Post) {
            return redirect()->to($post->link())->with('success', '编辑成功');
        } else {
            return redirect()->back()->withErrors(['error' => $result->getMessage()]);
        }
    }

    public function destroy(Post $post)
    {
        $this->authorize('own', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('success', '删除成功！');
    }
}
