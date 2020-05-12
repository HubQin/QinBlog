<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * 评论被回复通知
 * Class CommentReplied
 * @package App\Notifications
 */
class CommentReplied extends Notification
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase()
    {
        // 回复所在的文章
        $post = $this->reply->commentable;
        // 文章链接
        $link =  $post->link(['#comment' . $this->reply->id]);

        $parentCommentContent = make_excerpt($this->reply->parentComment->content, 30) . '...';

        // 存入数据库里的数据
        return [
            'comment_id' => $this->reply->id,
            'comment_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'post_link' => $link,
            'post_id' => $post->id,
            // 上级评论内容
            'parent_comment_content' => $parentCommentContent,
        ];
    }
}
