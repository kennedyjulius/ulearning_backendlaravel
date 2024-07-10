<?php

namespace App\Http\Controllers;

use App\Models\CourseType;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CourseTypeController extends AdminController
{

    public function index(Content $content){
        return $content->header('Course Types');
    
    protected function detail($id)
    {

        $show = new show(new CourseType::findOrFail($id));

        $show = new Grid(new User());
        $show->field('id', __('Id'));
        $show->field('title', __('Category'));
        $show->field('description', __('Description'));
        $show->field('order', __('Order'));
        $show->field('updated_at', __('Updated at'));
        // $show->disableActions();
        // $show->disableCreateButton();
        // $show->disableExport();
        // $show->disableFilter();

        return $show;
}

protected function form(){
    $form = new Form(new CourseType());
    $form ->select('parent_id', __('Parent Category'))->options( new CourseType())::selectOptions());
    $form ->text('title', __('Title'));
    $form ->text('description', __('Description'));
    $form ->number('Order', __('Order'));

    return $form;
}
}