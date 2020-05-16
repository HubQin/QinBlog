<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property int|null $parent_id
 * @property int $approved 是否审核通过
 * @property int $commentable_id
 * @property string $commentable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $replies
 * @property-read int|null $replies_count
 * @property-read \App\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Comment withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Comment|null $parentComment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment recently()
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content'];

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 一个评论有多个回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function getChildIds($id, &$ids = [])
    {
        $ids[] = $id;
        $childIds = $this->where('parent_id', $id)->get('id')->pluck('id');
        foreach ($childIds as $childId) {
            $this->getChildIds($childId, $ids);
        }
    }

    public function scopeRecently($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
