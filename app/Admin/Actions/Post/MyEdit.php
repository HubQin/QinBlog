<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class MyEdit extends RowAction
{
    public $name = '编辑';

    /**
     * @return string
     */
    public function href()
    {
        return route('posts.create', $this->getKey());
    }

    public function render()
    {
        $href = $this->href();

        return "<a href='{$href}' target='_blank'>{$this->name()}</a>";
    }
}
