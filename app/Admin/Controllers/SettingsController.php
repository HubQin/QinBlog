<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Setting;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Admin;

class SettingsController extends Controller
{
    public function settings(Content $content)
    {
        Admin::script(<<< JS
    // 点击 X 按钮时标记图片已经移除，不然后端无法知道
    $('#pjax-container').on('click', '.fileinput-remove', function() {
        let field = $(this).closest('.file-input').find("input[type='file']").attr('name');
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "removed_image[]";
        input.value = field;
        $(this).closest('.file-input').append(input);
    })

JS
        );
        return $content
            ->title('网站设置')
            ->body(new Setting());
    }
}
