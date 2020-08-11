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

Route::group(['prefix' =>'/teacher'], function (){

    Route::get('/', [
        'as' => 'admin.teacher.index',
        'uses' => 'Teacher\TeacherController@index',

    ])->middleware('permission:admin.teacher.index');

    Route::get('/{teacher}/view', [
        'as' => 'admin.teacher.view',
        'uses' => 'Teacher\TeacherController@view',

    ])->middleware('permission:admin.teacher.view');

    Route::get('/create', [
        'as' => 'admin.teacher.create',
        'uses' => 'Teacher\TeacherController@create',
    ])->middleware('permission:admin.teacher.create');

    Route::get('/{teacher}/edit/{locale?}', [
        'as' => 'admin.teacher.edit',
        'uses' => 'Teacher\TeacherController@edit',
    ])->middleware('permission:admin.teacher.edit');

    Route::post('/', [
        'as' => 'admin.teacher.destroy',
        'uses' => 'Teacher\TeacherController@destroy',

    ])->middleware('permission:admin.teacher.destroy');
    Route::get('/download', [
        'as' => 'admin.teacher.download',
        'uses' => 'Teacher\TeacherController@download',
    ]);
});
