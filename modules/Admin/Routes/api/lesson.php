<?php

use Illuminate\Http\Request;

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


Route::middleware('auth:api')->prefix('lesson')->group(function (){
    Route::get('/', [
        'as' => 'api.lesson.index',
        'uses' => 'Lesson\LessonController@index',

    ]);
    Route::get('/all', [
        'as' => 'api.lesson.all',
        'uses' => 'Lesson\LessonController@all',

    ]);
    Route::get('/qrcode', [
        'as' => 'api.lesson.qrcode',
        'uses' => 'Lesson\LessonController@qrcode',

    ]);
    Route::delete('/{lesson}', [
        'as' => 'api.lesson.destroy',
        'uses' => 'Lesson\LessonController@destroy',

    ])->middleware('permission:admin.lesson.destroy');

    Route::post('/store', [
        'as' => 'api.lesson.store',
        'uses' => 'Lesson\LessonController@store',

    ]);
    Route::get('/{lesson}/{locale?}', [
        'as' => 'api.lesson.find',
        'uses' => 'Lesson\LessonController@find',

    ]);
    Route::post('/{lesson}/edit', [
        'as' => 'api.lesson.update',
        'uses' => 'Lesson\LessonController@update',

    ]);
    Route::post('/{lesson}/update-status', [
        'as' => 'api.lesson.update-status',
        'uses' => 'Lesson\LessonController@updateStatus',

    ]);
});

Route::get('/lessons/students', [
    'as' => 'api.lesson.student',
    'uses' => 'Lesson\LessonController@getListStudentsByLesson',
    'middleware' => 'auth:api'
]);
