<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class AllCourseListController extends Controller
{
    public function index(){
        if (auth()->user()->is_lecturer !== 1) {
            return redirect('/');
        }
        $courses = Course::all();
        return view('courses.allCourse', compact('courses'));
    }
}
