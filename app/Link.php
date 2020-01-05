<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Link
 *
 * @property int $id
 * @property string $name 名称
 * @property string $url 链接地址
 * @property string $logo 图片
 * @property int $sort 排序
 * @property int $status 是否显示
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Link whereUrl($value)
 * @mixin \Eloquent
 */
class Link extends Model
{
    protected $fillable = ['name', 'url', 'logo'];
}
