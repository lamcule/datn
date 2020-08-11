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


Route::middleware('auth:api')->prefix('grade')->group(function (){
    Route::get('/', [
        'as' => 'api.grade.index',
        'uses' => 'Grade\GradeController@index',

    ]);
    Route::get('/all', [
        'as' => 'api.grade.all',
        'uses' => 'Grade\GradeController@all',

    ]);
    Route::delete('/{grade}', [
        'as' => 'api.grade.destroy',
        'uses' => 'Grade\GradeController@destroy',

    ])->middleware('permission:admin.grade.destroy');
    Route::post('/store', [
        'as' => 'api.grade.store',
        'uses' => 'Grade\GradeController@store',

    ]);
    Route::get('/{grade}/{locale?}', [
        'as' => 'api.grade.find',
        'uses' => 'Grade\GradeController@find',

    ]);
    Route::post('/{grade}/edit', [
        'as' => 'api.grade.update',
        'uses' => 'Grade\GradeController@update',

    ]);
    Route::post('/{grade}/update-status', [
        'as' => 'api.grade.update-status',
        'uses' => 'Grade\GradeController@updateStatus',

    ]);
    Route::post('/{grade}/regist', [
        'as' => 'api.grade.regist',
        'uses' => 'Grade\GradeController@regist',

    ]);

});

Route::get('/grades/students', [
    'as' => 'api.grade.student',
    'uses' => 'Grade\GradeController@getListStudentsByGrade',
    'middleware' => 'auth:api'
]);
