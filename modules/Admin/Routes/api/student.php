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


Route::middleware('auth:api')->prefix('students')->group(function (){

    Route::get('/', [
        'as' => 'api.student.index',
        'uses' => 'Student\StudentController@index',
    ]);
    Route::get('/all', [
        'as' => 'api.student.all',
        'uses' => 'Student\StudentController@all',
    ]);
    Route::get('/{user}', [
        'as' => 'api.student.find',
        'uses' => 'Student\StudentController@find',
    ]);

    Route::delete('/{user}', [
        'as' => 'api.student.destroy',
        'uses' => 'Student\StudentController@destroy',
    ]);

    Route::post('/', [
        'as' => 'api.student.store',
        'uses' => 'Student\StudentController@store',
    ]);

    Route::post('/{user}/edit', [
        'as' => 'api.student.update',
        'uses' => 'Student\StudentController@update',
    ]);

    Route::post('/import', [
        'as' => 'api.student.import',
        'uses' => 'Student\StudentController@import',

    ]);
});

Route::post('/contact', [
    'as' => 'api.student.contact',
    'uses' => 'Student\StudentController@saveContact',
]);
