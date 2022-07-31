<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::middleware('json')->get('/checkquiz', [App\Http\Controllers\QuizController::class, 'checkQuiz']);
Route::apiResource('checkQuiz', App\Http\Controllers\Api\QuizChecker::class)->names([
    'store' => 'checkQuiz.check',
]);

Route::apiResource('userMedal', App\Http\Controllers\Api\UserMedalController::class)->names([
    'store' => 'userMedal.check',
]);

Route::apiResource('userInfo', App\Http\Controllers\Api\UserInfoController::class)->names([
    'update' => 'userInfo.update',
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
