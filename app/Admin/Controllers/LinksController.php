<?php

namespace App\Admin\Controllers;

use App\Link;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LinksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '友情链接';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Link());
        $states = [
            'on'  => ['value' => 1, 'text' => '显示', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '隐藏', 'color' => 'danger'],
        ];

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', '名称')->editable();
        $grid->column('url', 'Url')->editable();
        $grid->column('sort', '排序')->editable()->sortable();
        $grid->column('status', '状态')->switch($states);

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Link());

        $form->text('name', '名称');
        $form->url('url', 'Url');
        $form->text('logo', 'Logo');
        $form->number('sort', '排序')->default(0);
        $form->switch('status', '状态')->default(1);

        return $form;
    }
}
