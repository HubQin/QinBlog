<?php

namespace App\Admin\Forms;

use App\Services\ImageUploader;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;
use DB;

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
        $data = $request->except(['logo', 'qr_weapp', 'qr_wechat_office', 'avatar']);

        $uploader = app(ImageUploader::class);
        $originalConfigs = config('site');

        // 上传图片
        foreach (['logo', 'qr_weapp', 'qr_wechat_office'] as $field) {
            if ($file = $request->file($field)) {
                $result = $uploader->save($file, 'site', 1024);
                if ($result) {
                    $data[$field] = $result['path'];
                }
            } else {
                // 没编辑的且原来有值的 保持住
                empty($originalConfigs[$field]) || $data[$field] = $originalConfigs[$field];
            }
        }

        // 更新站长头像
        if ($file = $request->file('avatar')) {
            $result = $uploader->save($file, 'site', 1024);
            if ($result) {
                $this->updateAdminAvatar($result['path']);
            }
        }

        file_put_contents(config_path('site').'.php', '<?php return ' . var_export($data, true) . ';');

        // 清理缓存
        $this->clearCache();

        admin_success('修改成功');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form(){
        $this->text('name', '网站名称')->rules('required');
        $this->text('slogan', '标语');
        $this->image('logo', '网站图标')->uniqueName()->move('public/upload/image1/');;
        $this->image('qr_wechat_office', '公众号二维码')->uniqueName();
        $this->image('qr_weapp', '小程序二维码')->uniqueName();
        $this->text('beian', '备案号');
        $this->color('main_color', '主色调')->default('#ccc');
        $this->email('email', '站长邮箱')->rules('email');
        $this->image('avatar', '站长头像');
        $this->text('notice', '站点公告');
        $this->text('footer', '页脚标语');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data(){
        return array_merge(config('site'), ['avatar' => $this->getAdminAvatar()]);
    }

    private function getAdminAvatar()
    {
        return DB::table('users')->where('id', 1)->value('avatar');
    }

    private function updateAdminAvatar($path)
    {
        DB::table('users')->where('id', 1)->update(['avatar' => $path]);
    }

    private function clearCache()
    {
        if (app()->environment('production')) {
            \Artisan::call('config:clear');
            \Artisan::call('config:cache');
        }

        cache()->forget('site_configs');
    }
}
