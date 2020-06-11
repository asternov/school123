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
