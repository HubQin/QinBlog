<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name 名称
 * @property string $icon 图标
 * @property string|null $description 描述
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @mixin \Eloquent
 * @property int $post_count 分类下的文章总数
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category wherePostCount($value)
 */
class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'icon', 'description'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($model) {
            if (count($model->posts)) {
                throw new \Exception('该分类下已有文章，不能删除');
            }
        });
    }

    public function categoryList()
    {
        // 输出有文章的分类
        return static::with('posts')->whereHas('posts', function ($q) {
            $q->where('is_show', 1);
        })->get();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
