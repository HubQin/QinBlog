<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 创建评论
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Comment $comment)
    {
        $request->validate([
            'content'=>'required',
        ]);

        $comment->content = $request->get('content');
        $comment->user()->associate($request->user());

        // 是否审核
        $comment->approved = $request->user()->id === 1 ? true : false;

        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment);

        return redirect()->to($post->link(['#comment' . $comment->id]))->with('success', '评论成功');
    }

    /**
     * 创建评论回复
     * @param Request $request
     * @param Comment $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replyStore(Request $request, Comment $reply)
    {
        $request->validate([
            'content'=>'required',
        ]);

        $reply->content = $request->get('content');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('parent_id');

        // 是否审核
        $reply->approved = $request->user()->id === 1 ? true : false;

        $post = Post::find($request->get('post_id'));
        $post->comments()->save($reply);

        return redirect()->to($post->link(['#comment' . $reply->id]))->with('success', '回复成功');
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('own', $comment);

        $comment->delete();

        return back()->with('success', '删除成功');
    }
}
