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

Route::group(['prefix' =>'/lesson'], function (){

    Route::get('/', [
        'as' => 'admin.lesson.index',
        'uses' => 'Lesson\LessonController@index',

    ])->middleware('permission:admin.lesson.index');

    Route::get('/{lesson}/view', [
        'as' => 'admin.lesson.view',
        'uses' => 'Lesson\LessonController@view',

    ])->middleware('permission:admin.lesson.view');

    Route::get('/create', [
        'as' => 'admin.lesson.create',
        'uses' => 'Lesson\LessonController@create',
    ])->middleware('permission:admin.lesson.create');

    Route::get('/{lesson}/edit/{locale?}', [
        'as' => 'admin.lesson.edit',
        'uses' => 'Lesson\LessonController@edit',
    ])->middleware('permission:admin.lesson.edit');
    Route::post('/', [
        'as' => 'admin.lesson.destroy',
        'uses' => 'Lesson\LessonController@destroy',

    ])->middleware('permission:admin.lesson.destroy');

	Route::get('/download', [
		'as' => 'admin.lesson.download',
		'uses' => 'Lesson\LessonController@download',
	]);
});

Route::group(['prefix' =>'/qrcode'], function (){

    Route::get('/', [
        'as' => 'admin.lesson.qrcode',
        'uses' => 'Lesson\LessonController@qrcode',

    ])->middleware('permission:admin.lesson.qrcode');

});

Route::group(['prefix' =>'/checkinout'], function (){

    Route::get('/', [
        'as' => 'admin.checkinout.index',
        'uses' => 'UserLesson\UserLessonController@index',

    ])->middleware('permission:admin.checkinout.index');
    Route::get('/download', [
        'as' => 'admin.checkinout.download',
        'uses' => 'UserLesson\UserLessonController@download',

    ])->middleware('permission:admin.checkinout.download');
});
