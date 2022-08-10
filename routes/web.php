<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllCourseController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/courses/{course:slug}/{lesson:slug?}', [App\Http\Controllers\CourseController::class, 'show'])->name('courses.show')->middleware('auth');

Route::get('/courses', function(){
    return view('courses.allCourse');
})->name('course.allCourses');


Route::get('/allCourse', [AllCourseController::class, 'index']);
Route::get('/add-course', [AllCourseController::class, 'create']);
Route::post('/add-course',[AllCourseController::class, 'store']);
Route::get('/edit-course/{id}',[AllCourseController::class, 'edit']);
Route::put('/update-course/{id}',[AllCourseController::class, 'update']);
Route::get('/delete-course/{id}',[AllCourseController::class, 'destroy']);
