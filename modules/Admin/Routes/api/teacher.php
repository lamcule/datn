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


Route::middleware('auth:api')->prefix('teacher')->group(function (){

    Route::get('/', [
        'as' => 'api.teacher.index',
        'uses' => 'Teacher\TeacherController@index',
    ]);
    Route::get('/all', [
        'as' => 'api.teacher.all',
        'uses' => 'Teacher\TeacherController@all',
    ]);
//    Route::get('/{user}', [
//        'as' => 'api.teacher.find',
//        'uses' => 'Teacher\TeacherController@find',
//    ]);
//
//    Route::delete('/{user}', [
//        'as' => 'api.teacher.destroy',
//        'uses' => 'Teacher\TeacherController@destroy',
//    ]);
//
//    Route::post('/', [
//        'as' => 'api.teacher.store',
//        'uses' => 'Teacher\TeacherController@store',
//    ]);
//
//    Route::post('/{user}/edit', [
//        'as' => 'api.teacher.update',
//        'uses' => 'Teacher\TeacherController@update',
//    ]);
//
    Route::post('/import', [
        'as' => 'api.teacher.import',
        'uses' => 'Teacher\TeacherController@import',

    ]);
});
