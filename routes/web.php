<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'CourseController@index')->name('/');
Route::get('', 'CourseController@index')->name('/');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vjs', function() {
    return view('vjs');
})->name('vjs');

Route::group(['prefix' => 'users', 'middleware' => 'auth', 'as' => 'users'], function () {
    Route::get('edit/{id}', 'UserController@edit')->name('.edit');
    Route::get('create', 'UserController@create')->name('.create');
    Route::post('store', 'UserController@store')->name('.store');
    Route::post('update/{id}', 'UserController@update')->name('.update');
    Route::get('destroy/{id}', 'UserController@destroy')->name('.destroy');
    Route::get('', 'UserController@index');
});

Route::group(['prefix' => 'courses', 'middleware' => 'auth', 'as' => 'courses'], function () {
    Route::get('edit/{course}', 'CourseController@edit')->name('.edit');
    Route::get('create', 'CourseController@create')->name('.create');
    Route::post('store', 'CourseController@store')->name('.store');
    Route::post('update/{course}', 'CourseController@update')->name('.update');
    Route::get('destroy/{course}', 'CourseController@destroy')->name('.destroy');
    Route::get('{course}', 'CourseController@show')->name('.show');
    Route::get('', 'CourseController@index');
});

Route::group(['prefix' => 'lessons', 'middleware' => 'auth', 'as' => 'lessons'], function () {
    Route::get('edit/{lesson}', 'LessonController@edit')->name('.edit');
    Route::get('create/{course}', 'LessonController@create')->name('.create');
    Route::post('store', 'LessonController@store')->name('.store');
    Route::post('update/{lesson}', 'LessonController@update')->name('.update');
    Route::get('destroy/{lesson}', 'LessonController@destroy')->name('.destroy');
    Route::get('{lesson}', 'LessonController@show')->name('.show');
    Route::get('', 'LessonController@index');
});


Route::group(['prefix' => 'comments', 'middleware' => 'auth', 'as' => 'comments'], function () {
    Route::get('edit/{lesson}', 'CommentController@edit')->name('.edit');
    Route::get('create/{course}', 'CommentController@create')->name('.create');
    Route::post('store/{lesson}', 'CommentController@store')->name('.store');
    Route::post('update/{lesson}', 'CommentController@update')->name('.update');
    Route::get('destroy/{lesson}', 'CommentController@destroy')->name('.destroy');
    Route::get('{lesson}', 'CommentController@show')->name('.show');
    Route::get('', 'CommentController@index');
});

Route::group(['prefix' => 'attachments', 'middleware' => 'auth', 'as' => 'attachments'], function () {
    Route::post('store/{lesson}', 'AttachmentController@store')->name('.store');
    Route::get('show/{lesson}', 'AttachmentController@show')->name('.show');
    Route::get('delete/{attachment}', 'AttachmentController@destroy')->name('.delete');
});

Route::get('storage/attachments/{filename}', function ($filename)
{
    $path = storage_path('app/public/attachments/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
