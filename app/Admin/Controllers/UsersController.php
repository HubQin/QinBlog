<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->filter(function($filter){
            $filter->like('name', 'name');
        });

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', '用户名');
        $grid->column('avatar', '头像')->image('', 60, 60);
        $grid->column('email', 'Email');
        $grid->column('type', '认证类型');
        $grid->column('created_at', '创建时间')->sortable();
        $grid->column('updated_at', '更新时间');
        $grid->column('is_admin', '是否是管理员')->bool()->sortable();

        $grid->disableCreateButton();
        $grid->disableActions();

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('avatar', __('Avatar'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('openid', __('Openid'));
        $show->field('type', __('Type'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('is_admin', __('Is admin'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->image('avatar', __('Avatar'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('openid', __('Openid'));
        $form->text('type', __('Type'));
        $form->text('remember_token', __('Remember token'));
        $form->switch('is_admin', __('Is admin'));

        return $form;
    }
}
