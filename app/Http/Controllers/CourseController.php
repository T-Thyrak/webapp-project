<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\UserProgress;

class CourseController extends Controller
{
    public function show(Course $course, $lessonSlug = "") {
        $courses = Course::all();

        if ($lessonSlug !== "") {
            // echo 'huh';
            $lesson = CourseLesson::where('slug', $lessonSlug)->first();
            if ($lesson->type == 'video' || $lesson->type == 'text') {
                UserProgress::firstOrCreate([
                    'user_id' => auth()->id(),
                    'course_id' => $course->id,
                    'lesson_id' => $lesson->id,
                ]);
            }
            if ($lesson) {
                return view('courses.lesson', compact('courses', 'course', 'lesson'));
            } else {
                abort(404);
            }
        } else {
            // echo $lessonSlug;
            $lessons = CourseLesson::when(request('course_id'), function ($query) {
                return $query->where('course_id', request('course_id'));
            })->get();


            return view('courses.show', compact('courses', 'course', 'lessons'));
        }
    }
}
