<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Http\Requests\PostRequest;
use App\Services\ImageUploader;
use App\Services\PostService;
use App\Tag;
use App\Topic;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search', 'archiveShow']]);
    }

    public function index(Request $request)
    {
        $posts = Post::query()->with('category')->published()->recently()->paginate(20);
        return view('posts.index', compact('posts'));
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
        $data = $request->only(['title', 'body', 'category_id', 'is_show']);
        $post->fill($data);
        $post->user_id = \Auth::id();
        $post->body = parsedown($post->body);
        $post->body = app(CopyWritingCorrectService::class)->correct($post->body);

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
        if (!empty($post->slug) && $post->slug != $request->slug) {
            return redirect()->to($post->link(), 301);
        }

        $topicPosts = [];
        if ($post->topic_id > 0) {
            $topicPosts = Post::where('topic_id', $post->topic_id)->select(['id', 'title'])->orderBy('sort')->get();
        }

        $viewCountTodayInCache = $post->incrViewCount($post->id);

        return view('posts.show', compact('post', 'topicPosts', 'viewCountTodayInCache'));
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
        $data = $request->only(['title', 'body', 'category_id', 'is_show']);
        $post->fill($data);
        $post->body = parsedown($post->body);
        $post->body = app(CopyWritingCorrectService::class)->correct($post->body);


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

    public function archiveShow($year_month)
    {
        list($year, $month) = explode('-', $year_month);
        $posts = Post::query()->with('category')
            ->recently()
            ->published()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)->paginate(20);

        return view('posts.index', compact('posts', 'year', 'month'));
    }

    /**
     * 上传文章图片
     * @param Request $request
     * @param ImageUploader $uploader
     * @return array
     */
    public function uploadPostImage(Request $request, ImageUploader $uploader)
    {
        if ($file = $request->file) {
            $result = $uploader->save($file, 'posts', 1024);
            if ($result) {
                return [
                    'error'    => '上传成功',
                    'filename' => $result['path']
                ];
            }
        }

        return [
            'error'    => '上传失败',
            'filename' => ''
        ];
    }

    /**
     * 文章全文检索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = strip_tags(clean($request->get('query')));

        $posts = Post::search($keyword)->when(! \Auth::user()->is_admin, function ($query) {
            $query->where('is_show', 1);
        })->orderBy('created_at', 'desc')->paginate(20);

        return view('posts.search', compact('posts'));
    }
}
