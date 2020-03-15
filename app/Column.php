<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Column
 *
 * @property int $id
 * @property string $name 名称
 * @property string $link 地址
 * @property string|null $description 描述
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Column whereName($value)
 * @mixin \Eloquent
 */
class Column extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'link', 'description'];
}
