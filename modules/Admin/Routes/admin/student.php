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

Route::group(['prefix' =>'/students'], function (){

    // country
    Route::get('/', [
        'as' => 'admin.student.index',
        'uses' => 'Student\StudentController@index',

    ])->middleware('permission:admin.student.index');

    Route::get('/create', [
        'as' => 'admin.student.create',
        'uses' => 'Student\StudentController@create',
    ])->middleware('permission:admin.student.create');

    Route::get('/{user}/edit', [
        'as' => 'admin.student.edit',
        'uses' => 'Student\StudentController@edit',
    ])->middleware('permission:admin.student.edit');

    Route::post('/', [
        'as' => 'admin.student.destroy',
        'uses' => 'Student\StudentController@destroy',
    ])->middleware('permission:admin.student.destroy');

    Route::group(['prefix' =>'/register'], function (){
        Route::get('/', [
            'as' => 'admin.student_register.index',
            'uses' => 'StudentGuest\StudentGuestController@index',

        ])->middleware('permission:admin.student.index');

        Route::get('/create', [
            'as' => 'admin.student_register.create',
            'uses' => 'StudentGuest\StudentGuestController@create',
        ])->middleware('permission:admin.student.create');

        Route::get('/{user}/edit', [
            'as' => 'admin.student_register.edit',
            'uses' => 'StudentGuest\StudentGuestController@edit',
        ])->middleware('permission:admin.student.edit');

        Route::post('/', [
            'as' => 'admin.student_register.destroy',
            'uses' => 'Student\StudentController@destroy',
        ])->middleware('permission:admin.student.destroy');

    });

});
