<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\UserProgress;

class QuizChecker extends Controller
{
    public function store(Request $request) {
        $req = $request->collect();
        // $user_id = $request->user()->id;

        $user_id = $req['user_id'];

        $course_id = $req['course_id'];
        $lesson_id = $req['lesson_id'];

        $answers = $req['answers'];

        if (count((array) $answers) == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No answers provided',
            ]);
        }

        $ra = [];

        foreach ($answers as $answer) {
            $quiz = Quiz::find($answer['question']);
            if ($quiz->correct_answer == $answer['answer']) {
                $ra[] = true;
            } else {
                $ra[] = false;
            }
        }

        if (QuizChecker::allOf($ra)) {
            UserProgress::firstOrCreate([
                'user_id' => $user_id,
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
            ]);
            return response()->json([
                'status' => 'success',
                'correct' => true,
                'message' => 'Quiz passed!',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'correct' => false,
                'message' => 'Quiz failed!',
            ]);
        }
    }

    private static function allOf($array) {
        foreach ($array as $item) {
            if (!$item) {
                return false;
            }
        }
        return true;
    }
}
