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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'courses', 'middleware' => 'auth', 'as' => 'courses'], function () {
Route::get('{course}', 'CourseController@show')->name('api.courses.show');
Route::get('', 'CourseController@index');
});

Route::group(['prefix' => 'lessons', 'middleware' => 'auth', 'as' => 'lessons'], function () {
Route::get('{lesson}', 'LessonController@show')->name('api.lessons.show');
Route::get('', 'LessonController@index');
});
