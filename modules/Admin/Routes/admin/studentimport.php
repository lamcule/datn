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

Route::group(['prefix' =>'/student-import'], function (){

    // country
    Route::get('/', [
        'as' => 'admin.studentimport.index',
        'uses' => 'StudentImport\StudentImportController@index',

    ])->middleware('permission:admin.studentimport.index');

    Route::get('/create', [
        'as' => 'admin.studentimport.create',
        'uses' => 'StudentImport\StudentImportController@create',
    ])->middleware('permission:admin.studentimport.create');

    Route::get('/{studentimport}/edit', [
        'as' => 'admin.studentimport.edit',
        'uses' => 'StudentImport\StudentImportController@edit',
    ])->middleware('permission:admin.studentimport.edit');
    Route::get('/{studentimport}', [
        'as' => 'admin.studentimport.view',
        'uses' => 'StudentImport\StudentImportController@view',
    ])->middleware('permission:admin.studentimport.view');
});
