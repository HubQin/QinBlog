<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

/**
 * 评论批量审核
 * Class ReviewComment
 * @package App\Admin\Extensions\Tools
 */
class ReviewComment extends BatchAction
{
    protected $approved;

    public function __construct($approved = 1)
    {
        $this->approved = $approved;
    }

    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {
    $.ajax({
        method: 'post',
        url: '{$this->resource}/review',
        data: {
            _token:LA.token,
            ids: $.admin.grid.selected(),
            approved: {$this->approved}
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        }
    });
});

EOT;

    }
}
