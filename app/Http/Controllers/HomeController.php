<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserMedal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = Course::all();
        $medals = UserMedal::where('user_id', auth()->user()->id)->get();
        $ratio = round($medals->count() / $courses->count());
        $courses_medals = $courses->whereIn('id', $medals->pluck('course_id'));

        $amedals = [];

        foreach ($medals as $medal) {
            $amedals[$medal->course_id] = [
                'course_id' => $medal->course_id,
                'course_name' => $courses->where('id', $medal->course_id)->first()->name,
            ];
        }
        // get object courses that are in the medals table

        return view('home', compact('ratio', 'amedals'));
    }
}
