<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\UserMedal;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class UserMedalController extends Controller
{
    //

    public function store(Request $request) {
        $req = $request->collect();

        $user_id = $req['user_id'];

        $courses = Course::all();

        foreach($courses as $course) {
            $progress_per_course = UserProgress::where([
                'user_id' => $user_id,
                'course_id' => $course->id,
            ])->count();

            $lessons_count = CourseLesson::where('course_id', $course->id)->count();

            if ($progress_per_course == $lessons_count) {
                UserMedal::firstOrCreate([
                    'user_id' => $user_id,
                    'course_id' => $course->id,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Medal are synced!',
        ]);
    }
}
