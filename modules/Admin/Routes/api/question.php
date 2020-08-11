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


Route::middleware('auth:api')->prefix('question-group')->group(function (){

    Route::get('/', [
        'as' => 'api.questiongroup.index',
        'uses' => 'QuestionGroup\QuestionGroupController@index',
    ]);
    Route::get('/all', [
        'as' => 'api.questiongroup.all',
        'uses' => 'QuestionGroup\QuestionGroupController@all',
    ]);


});
