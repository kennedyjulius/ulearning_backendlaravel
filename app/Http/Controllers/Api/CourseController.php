<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courseList() {
        $result = Course::select('name', 'thumbnail', 'lesson_num', 'price', 'id')->get();
        return response()->json([
            'code' => 200,
            'msg' => "User logged Successfully",
            'data' => $user,
        ], 200);
    }catch(\throwable $throw){
        return response()->json([
            'code'=>500,
            'msd'=>'The Column does not exist or you have a Syntax error'
            'data' =>$throw->getMessage(),

        ])
    }

}
