<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseLesson;

class CourseController extends Controller
{
    public function show(Course $course, $lessonSlug = "") {
        if ($lessonSlug !== "") {
            // echo 'huh';
            $lesson = CourseLesson::where('slug', $lessonSlug)->first();
            if ($lesson) {
                return view('courses.lesson', compact('course', 'lesson'));
            } else {
                abort(404);
            }
        } else {
            // echo $lessonSlug;
            $lessons = CourseLesson::when(request('course_id'), function ($query) {
                return $query->where('course_id', request('course_id'));
            })->get();

            return view('courses.show', compact('course', 'lessons'));
        }
    }
}
