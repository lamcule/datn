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


Route::middleware('auth:api')->prefix('course')->group(function () {
    Route::get('/', [
        'as' => 'api.course.index',
        'uses' => 'Course\CourseController@index',

    ]);
    Route::get('/all', [
        'as' => 'api.course.all',
        'uses' => 'Course\CourseController@all',

    ]);
    Route::delete('/{course}', [
        'as' => 'api.course.destroy',
        'uses' => 'Course\CourseController@destroy',

    ])->middleware('permission:admin.course.destroy');
    Route::post('/store', [
        'as' => 'api.course.store',
        'uses' => 'Course\CourseController@store',

    ]);
    Route::get('/{course}/{locale?}', [
        'as' => 'api.course.find',
        'uses' => 'Course\CourseController@find',

    ]);
    Route::post('/{course}/edit', [
        'as' => 'api.course.update',
        'uses' => 'Course\CourseController@update',

    ]);
    Route::post('/{course}/update-status', [
        'as' => 'api.course.update-status',
        'uses' => 'Course\CourseController@updateStatus',

    ]);
});

Route::get('/province', [
    'as' => 'api.province.index',
    'uses' => 'Course\CourseController@getProvinces'
]);

Route::get('/active-course', [
    'as' => 'api.course.active',
    'uses' => 'Course\CourseController@getActiveCourse'
]);
