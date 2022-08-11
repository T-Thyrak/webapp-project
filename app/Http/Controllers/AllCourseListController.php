<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class AllCourseListController extends Controller
{
    public function index(){
        $courses = Course::all();
        return view('courses.allCourse', compact('courses'));
    }
}
