<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Setting extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '网站设置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request){
//        file_put_contents(__DIR__ . '/test.txt', json_encode($request->file()));

        $data = $request->all();
        file_put_contents(config_path('site').'.php', '<?php return ' . var_export($data, true) . ';');
        admin_success('修改成功');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form(){
        $this->text('name')->rules('required');
        $this->text('slogan');
        $this->image('logo')->uniqueName();
        $this->image('qr_wechat_office')->uniqueName();
        $this->image('qr_weapp')->uniqueName();
        $this->text('beian');
        $this->color('main_color');
        $this->email('email')->rules('email');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data(){
        return config('site');
    }
}
