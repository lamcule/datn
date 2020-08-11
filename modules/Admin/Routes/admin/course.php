<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' =>'/course'], function (){

    Route::get('/', [
        'as' => 'admin.course.index',
        'uses' => 'Course\CourseController@index',

    ])->middleware('permission:admin.course.index');

    Route::get('/{course}/view', [
        'as' => 'admin.course.view',
        'uses' => 'Course\CourseController@view',

    ])->middleware('permission:admin.course.view');

    Route::get('/create', [
        'as' => 'admin.course.create',
        'uses' => 'Course\CourseController@create',
    ])->middleware('permission:admin.course.create');

    Route::get('/{course}/edit/{locale?}', [
        'as' => 'admin.course.edit',
        'uses' => 'Course\CourseController@edit',
    ])->middleware('permission:admin.course.edit');

    Route::post('/', [
        'as' => 'admin.course.destroy',
        'uses' => 'Course\CourseController@destroy',

    ])->middleware('permission:admin.course.destroy');
    Route::get('/download', [
        'as' => 'admin.course.download',
        'uses' => 'Course\CourseController@download',
    ]);
});
