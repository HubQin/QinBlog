<?php

namespace App\Admin\Controllers;

use App\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Admin;

class CategoriesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        Admin::style('.icon {
            width: 2em; height: 2em;
            vertical-align: -0.15em;
            fill: currentColor;
            overflow: hidden;
            margin-right:8px;
        }');

        $grid = new Grid(new Category());

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', '分类名');
        $grid->column('icon', 'Iconfont 图标')->display(function ($value) {
            return '<svg class="icon" aria-hidden="true">
                            <use xlink:href="#' . $value . '"></use>
                    </svg><span>' . $value . '</span>';
        });
        $grid->column('post_count', '文章数')->sortable();
        $grid->column('description', '分类描述');

        $grid->actions(function ($actions) {
            $actions->disableView();
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
        $form = new Form(new Category());

        $form->text('name', '分类名称')->rules('required');
        $form->text('icon', 'Iconfont 图标')->rules('required');
        $form->textarea('description', '分类描述');

        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
        });

        return $form;
    }
}
