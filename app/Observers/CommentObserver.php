<?php

namespace App\Observers;

use App\Comment;
use App\Notifications\CommentReplied;
use App\Notifications\PostCommented;
use Carbon\Carbon;
use DB;
use Ricoa\CopyWritingCorrect\CopyWritingCorrectService;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        $comment->content = parsedown($comment->content);
        $comment->content = app(CopyWritingCorrectService::class)->correct($comment->content);
        $comment->content = clean($comment->content, 'post_body');
    }

    public function created(Comment $comment)
    {
        $this->updatePostCount($comment);
        $postUser = $comment->commentable->user;

        // 通知文章作者
        $postUser->commentNotify(new PostCommented($comment));

        // 如果是对评论的回复，还要通知该评论的作者
        if($comment->parent_id && $postUser->id != $comment->parentComment->user->id) {
            $comment->parentComment->user->commentNotify(new CommentReplied($comment));
        }
    }

    public function deleted(Comment $comment)
    {
        // 所有下级标记为删除
        $ids = [];
        $comment->getChildIds($comment->id, $ids);
        if ($ids) {
            DB::table('comments')->whereIn('id', $ids)->update(['deleted_at' => Carbon::now()]);
        }

        $this->updatePostCount($comment);
    }

    private function updatePostCount($comment)
    {
        $item = $comment->commentable;
        if ($item instanceof \App\Post) {
            $count = DB::table('comments')
                ->where('commentable_id', $item->id)
                ->where('commentable_type', 'App\\Post')
                ->whereNull('deleted_at')
                ->count();

            DB::table('posts')
                ->where('id', $item->id)
                ->update(['comment_count' => $count]);
        }
    }
}
