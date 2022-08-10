<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\UserMedal;
use App\Models\UserProgress;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    public function index(){
        $courses = Course::all();
        return view('Course_CRUD.index', compact('courses'));
    }
    public function create(){
        return view('Course_CRUD.create');
    }
    public function store(Request $request){
        $course = new Course;
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->slug = $request->input('slug');
        if(!isset($course->slug)){
            $course->slug = 'N/A';
        }
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/course_images/', $filename);
            $course->image = $filename;
        }

        $course->save();
        return redirect()->back()->with('status', 'Course Image Added Successfully');
    }
    public function edit($id){
        $course = Course::find($id);
        return view('Course_CRUD.edit', compact('course'));
    }
    public function update(Request $request, $id){
        $course = Course::find($id);
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->slug = $request->input('slug');
        if(!isset($course->slug)){
            $course->slug = 'N/A';
        }
        if($request->hasfile('image')){
            $destination = 'uploads/course_images/'.$course->image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('uploads/course_images/', $filename);
            $course->image = $filename;
        }

        $course->update();
        return redirect()->back()->with('status', 'Course Image Updated Successfully');
    }
    public function destroy($id){
        $course = Course::find($id);
        $destination  = 'uploads/course_images/'.$course->image;
        if(File::exists($destination)){
            File::delete($destination);
        }
        $course->delete();
        return redirect()->back()->with('status', 'Course Image Deleted Successfully');

    }
    public function show(Course $course, $lessonSlug = "") {
        $courses = Course::where("under_construction", false)->get();

        if ($course->under_construction) {
            abort(401);
        }

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

            $_allCompleted = UserMedal::where([
                'user_id' => auth()->id(),
                'course_id' => $course->id,
            ]);

            if ($_allCompleted->count() != 0) {
                $allCompleted = true;
            } else {
                $allCompleted = false;
            }

            return view('courses.show', compact('allCompleted', 'courses', 'course', 'lessons'));
        }
    }
}
