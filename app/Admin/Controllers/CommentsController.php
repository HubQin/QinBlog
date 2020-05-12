<?php

namespace App\Admin\Controllers;

use App\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use App\Admin\Extensions\Tools\ReviewComment;

class CommentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {
            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->scope('approved', '待审核')->where('approved', 0);
        });

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->add('审核通过', new ReviewComment(1));
                $batch->add('设为待审核', new ReviewComment(0));
            });
        });

        $states = [
            'on'  => ['value' => 1, 'text' => 'Yes', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'No', 'color' => 'danger'],
        ];

        $grid->column('id', 'ID')->sortable();
        $grid->column('user.name', '用户名');
        $grid->column('content', '内容')->width(350)->view('admin.comment_content');
        $grid->column('parent_id', '上级ID');
        $grid->column('approved', '审核通过')->switch($states)->sortable();
        $grid->column('commentable_type', '所属类型');
        $grid->column('created_at', '创建时间')->sortable();

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('content', __('Content'));
        $show->field('parent_id', __('Parent id'));
        $show->field('approved', __('Approved'));
        $show->field('commentable_id', __('Commentable id'));
        $show->field('commentable_type', __('Commentable type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment());

        $form->number('user_id', __('User id'));
        $form->textarea('content', __('Content'));
        $form->number('parent_id', __('Parent id'));
        $form->switch('approved', __('Approved'));
        $form->number('commentable_id', __('Commentable id'));
        $form->text('commentable_type', __('Commentable type'));

        return $form;
    }

    public function review(Request $request)
    {
        foreach (Comment::find($request->get('ids')) as $comment) {
            $comment->approved = $request->get('approved');
            $comment->save();
        }
    }
}
