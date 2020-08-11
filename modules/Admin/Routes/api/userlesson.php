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


Route::middleware('auth:api')->prefix('userlesson')->group(function (){
    Route::get('/', [
        'as' => 'api.userlesson.index',
        'uses' => 'UserLesson\UserLessonController@index',

    ]);
    Route::post('/checkinout', [
        'as' => 'api.userlesson.checkinout',
        'uses' => 'UserLesson\UserLessonController@checkinout',

    ]);
});
