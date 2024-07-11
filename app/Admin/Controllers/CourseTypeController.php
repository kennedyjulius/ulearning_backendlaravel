<?php

namespace App\Http\Controllers;

use App\Models\CourseType;
use App\Models\Course;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class CourseTypeController extends AdminController
{
    public function index(Content $content)
    {
        $tree = new Tree(new CourseType);
        return $content
            ->header('Course Types')
            ->body($tree);
    }

    protected function form()
    {
        $form = new Form(new CourseType());
        
        $form->select('parent_id', __('Parent Category'))->options(CourseType::selectOptions());
        $form->text('title', __('Title'));
        $form->textarea('description', __('Description'));
        $form->number('order', __('Order'));

        return $form;
    }

    protected function grid()
    {
        $grid = new Grid(new CourseType());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('description', __('Description'));
        $grid->column('order', __('Order'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableFilter();

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(CourseType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('order', __('Order'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }
}
