<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Scout\Searchable;

/**
 * App\Post
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property int $topic_id 所属专题,0代表无专题
 * @property int $reply_count 回复数量
 * @property int $view_count 查看总数
 * @property int $order 排序
 * @property int $is_show 是否显示
 * @property string|null $excerpt 文章摘要，SEO 优化时使用
 * @property string|null $slug SEO 友好的 URI
 * @property string|null $icon 用于文章列表显示的图标
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $replies
 * @property-read int|null $replies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Topic $topic
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereIsShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereReplyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTopicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereViewCount($value)
 * @mixin \Eloquent
 * @property int $category_id
 * @property-read \App\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post recently()
 * @property int $sort 用于专题排序
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read mixed $tag_ids
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSort($value)
 * @property int $comment_count 评论数量
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCommentCount($value)
 */
class Post extends Model
{
    use Searchable;

    protected $fillable = [
        'title', 'body', 'excerpt', 'slug', 'topic_id', 'category_id', 'is_show'
    ];

    /**
     * 一篇文章属于一个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 一篇文章属于一个专题
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id')->where('topic_id', '>', 0);
    }

    /**
     * 定义文章与评论一对多多态关联
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    /**
     * 文章和标签为多对多关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }

    /**
     * 一篇文章属于一个分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 已发布的文章
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_show', 1);
    }

    public function scopeRecently($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    public function getTagIdsAttribute()
    {
        return $this->tags()->allRelatedIds();
    }

    public function link($params = [])
    {
        return route('posts.show', array_merge([$this->id, $this->slug], $params));
    }

    public function archiveList()
    {
        return static::recently()->published()->get()->groupBy(function ($post) {
            return Carbon::parse($post->created_at)->format('Y-m');
        });
    }

    public function toSearchableArray()
    {
        return $this->only('id', 'title', 'body');
    }
}
