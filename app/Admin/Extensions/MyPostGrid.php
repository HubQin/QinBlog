<?php


namespace App\Admin\Extensions;


use Encore\Admin\Grid;

class MyPostGrid extends Grid
{
    public function renderCreateButton()
    {
        $href = route('posts.create');
        return <<<EOT

<div class="btn-group pull-right grid-create-btn" style="margin-right: 10px">
    <a href="{$href}" class="btn btn-sm btn-success" title="新增" target="_blank">
        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;新增</span>
    </a>
</div>

EOT;
    }
}
