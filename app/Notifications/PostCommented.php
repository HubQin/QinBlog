<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * 文章被评论通知
 * Class PostCommented
 * @package App\Notifications
 */
class PostCommented extends Notification
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
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

    public function toDatabase($notifiable)
    {
        $post = $this->comment->commentable;
        $link =  $post->link(['#comment' . $this->comment->id]);

        // 存入数据库里的数据
        return [
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'user_avatar' => $this->comment->user->avatar,
            'post_link' => $link,
            'post_id' => $post->id,
            'post_title' => $post->title,
        ];
    }
}
