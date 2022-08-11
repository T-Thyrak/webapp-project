<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Courses;

class AllCourseController extends Controller
{
    public function index(){
        $courses = Courses::all();
        return view('allCouse.index', compact('courses'));
    }
    public function create(){
        if (auth()->user()->is_lecturer !== 1) {
            return redirect('/');
        }
        return view('allCouse.create');
    }
    public function store(Request $request){
        if (auth()->user()->is_lecturer !== 1) {
            return redirect('/');
        }
        $course = new Courses;
        $course->title = $request->input('title');
        $course->description = $request->input('description');
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
        if (auth()->user()->is_lecturer !== 1) {
            return redirect('/');
        }
        $course = Courses::find($id);
        return view('allCouse.edit', compact('course'));
    }
    public function update(Request $request, $id){
        if (auth()->user()->is_lecturer !== 1) {
            return redirect('/');
        }
        $course = Courses::find($id);
        $course->title = $request->input('title');
        $course->description = $request->input('description');
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
        if (auth()->user()->is_lecturer !== 1) {
            return redirect('/');
        }
        $course = Courses::find($id);
        $destination  = 'uploads/course_images/'.$course->image;
        if(File::exists($destination)){
            File::delete($destination);
        }
        $course->delete();
        return redirect()->back()->with('status', 'Course Image Deleted Successfully');
    }

}
