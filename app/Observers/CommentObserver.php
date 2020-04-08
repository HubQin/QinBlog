<?php

namespace App\Observers;

use App\Comment;
use Carbon\Carbon;
use DB;

class CommentObserver
{
    public function creating(Comment $comment)
    {
        $comment->content = parsedown($comment->content);
        $comment->content = clean($comment->content, 'post_body');
    }

    public function created(Comment $comment)
    {
        $this->updatePostCount($comment);
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
