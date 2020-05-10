<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Tag
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $post_count 标签下的文章总数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag wherePostCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $fillable=['name', 'post_count'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($model) {
            if (\DB::table('post_tag')->where('tag_id', $model->id)->count()) {
                throw new \Exception('该标签下已有文章，不能删除');
            }
        });
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function tagsList()
    {
        $colors = ['primary', 'secondary', 'success', 'danger', 'info'];

        return static::all()->map(function ($tag) use ($colors) {
            $tag->color = $colors[array_rand($colors)];
            return $tag;
        });
    }
}
