<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    //
    public function randomQuiz(int $course_id, int $lesson_id, int $count = 1) {
        $quizzes = Quiz::where([
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
        ])->get();

        $rq = [];

        for ($i = 0; $i < $count; $i++) {
            $rq[] = $quizzes->random();
        }

        return $rq;
    }

    public function checkQuiz(Request $request) {
        $req = $request->collect();

        return json_encode($req);
    }
}