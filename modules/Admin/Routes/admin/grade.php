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

Route::group(['prefix' =>'/grade'], function (){

    Route::get('/', [
        'as' => 'admin.grade.index',
        'uses' => 'Grade\GradeController@index',

    ])->middleware('permission:admin.grade.index');

    Route::get('/{grade}/view', [
        'as' => 'admin.grade.view',
        'uses' => 'Grade\GradeController@view',

    ])->middleware('permission:admin.grade.view');

    Route::get('/create', [
        'as' => 'admin.grade.create',
        'uses' => 'Grade\GradeController@create',
    ])->middleware('permission:admin.grade.create');

    Route::get('/{grade}/edit/{locale?}', [
        'as' => 'admin.grade.edit',
        'uses' => 'Grade\GradeController@edit',
    ])->middleware('permission:admin.grade.edit');
    Route::post('/', [
        'as' => 'admin.grade.destroy',
        'uses' => 'Grade\GradeController@destroy',

    ])->middleware('permission:admin.grade.destroy');
	Route::get('/download', [
		'as' => 'admin.grade.download',
		'uses' => 'Grade\GradeController@download',
	]);
});
