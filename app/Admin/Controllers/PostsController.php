<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\MyEdit;
use App\Admin\Extensions\Tools\MyPostGrid;
use App\Category;
use App\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Show;

class PostsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章';

    /**
     * Make a grid builder.
     *
     * @return MyPostGrid
     */
    protected function grid()
    {
        $grid = new MyPostGrid(new Post());

        $categories = Category::select(['id', 'name'])->orderBy('id')->get()->pluck('name', 'id');

        $grid->filter(function ($filter) use ($categories) {
            $filter->column(1 / 2, function ($filter) {
                $filter->like('title', '标题');
            });

            $filter->column(1 / 2, function ($filter) use ($categories) {
                $filter->equal('category_id', '分类')->select($categories);
                $filter->where(function ($query) {
                    $input = $this->input;
                    $query->whereHas('tags', function ($query) use ($input) {
                        $query->where('name', $input);
                    });

                }, '包含标签', 'tag');
            });

            $filter->scope('is_show', '隐藏的文章')->where('is_show', 0);
            $filter->scope('topic_id', '专题文章')->where('topic_id', '>', 0);
            $filter->scope('new', '今日更新')->whereDate('updated_at', date('Y-m-d'));
        });

        $states = [
            'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
        ];

        $grid->column('id', 'ID')->sortable();
        $grid->column('title', '标题')->width(350)->display(function ($value) {
            return "<a href='/posts/$this->id' target='_blank'>$value</a>";
        });
        $grid->column('user.name', '作者');
        $grid->column('category.name', '分类');
        $grid->column('topic_id', '专题')->display(function ($topicId) {
            if (!$topicId) {
                return '';
            }
            return \DB::table('topics')->where('id', $topicId)->value('name');
        })->sortable();
        $grid->column('tags', '标签')->display(function ($tags) {

            $tags = array_map(function ($tag) {
                return "<span class='label label-success'>{$tag['name']}</span>";
            }, $tags);

            return join('&nbsp;', $tags);
        });
        $grid->column('sort', '专题排序')->editable()->hide();
        $grid->column('comment_count', '评论数')->sortable();
        $grid->column('view_count', '浏览量')->sortable();
        $grid->column('order', '排序')->sortable()->editable()->hide();
        $grid->column('is_show', '是否显示')->sortable()->switch($states);
        $grid->column('excerpt', '摘要')->width(300);
        $grid->column('slug', 'Slug')->width(200);
        $grid->column('created_at', '创建时间')->date('Y-m-d');
        $grid->column('updated_at', '更新时间')->date('Y-m-d');


        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->add(new MyEdit);
        });

        return $grid;
    }
}
