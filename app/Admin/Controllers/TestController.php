<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\CourseType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TestController extends AdminController
{
    protected $title = 'Test';

    protected function form()
    {
        $form = new Form(new User());

        $form->text('id', __('Id'));
        $form->text('name', __('Name'));
        $form->text('email', __('Email'));
        $form->text('email_verified_at', __('Email verified at'))->default(date('Y-mm-dd'));
        $form->text('created_at', __('Created at'));
        $form->password('password', __('Password'));
        $form->image('avatar', __('Avatar'));

        $form->disableActions();
        $form->disableCreateButton();
        $form->disableExport();
        $form->disableFilter();

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new CourseType());

        $form->select('parent_id', __('Parent Category'))->options(CourseType::selectOptions());
        $form->text('title', __('Title'));
        $form->textarea('description', __('Description'));
        $form->number('order', __('Order'));
        $form->image('thumbnail', __('Thumbnail'))->uniqueName();
        $form->file('video', __('Video'))->uniqueName;
        $form->float('price', __('Price'));
        $form->number('lesson_num', __('Lesson number'));
        $form->float('video_length', __('Video length'));


        $result = User::pluck('name', 'token');
        dd($result);
        $form->display('Created at', __('Created at'));

        return $form;
    }
}
