<?php

namespace App\Admin\Controllers;

use App\Column;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ColumnsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '栏目';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Column());

        $grid->column('id', 'ID');
        $grid->column('name', '名称')->editable();
        $grid->column('link', '链接')->editable();
        $grid->column('description', '描述')->editable();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Column());

        $form->text('name', '名称');
        $form->text('link', '链接');
        $form->textarea('description', '描述');

        return $form;
    }
}
