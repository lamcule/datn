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


Route::middleware('auth:api')->prefix('student-import')->group(function (){

    Route::get('/', [
        'as' => 'api.studentimport.index',
        'uses' => 'StudentImport\StudentImportController@index',
    ]);

    Route::get('/{studentimport}', [
        'as' => 'api.studentimport.find',
        'uses' => 'StudentImport\StudentImportController@find',
    ]);

    Route::delete('/{studentimport}', [
        'as' => 'api.studentimport.destroy',
        'uses' => 'StudentImport\StudentImportController@destroy',
    ]);

    Route::post('/', [
        'as' => 'api.studentimport.store',
        'uses' => 'StudentImport\StudentImportController@store',
    ]);

    Route::post('/{studentimport}/edit', [
        'as' => 'api.studentimport.update',
        'uses' => 'StudentImport\StudentImportController@update',
    ]);

    Route::post('/{studentimport}/import', [
        'as' => 'api.studentimport.import',
        'uses' => 'StudentImport\StudentImportController@import',
    ]);
});


Route::middleware('auth:api')->prefix('import-detail')->group(function (){

    Route::get('/', [
        'as' => 'api.importdetail.index',
        'uses' => 'ImportDetail\ImportDetailController@index',
    ]);

    Route::get('/{importdetail}', [
        'as' => 'api.importdetail.find',
        'uses' => 'ImportDetail\ImportDetailController@find',
    ]);

    Route::delete('/{importdetail}', [
        'as' => 'api.importdetail.destroy',
        'uses' => 'ImportDetail\ImportDetailController@destroy',
    ]);

    Route::post('/', [
        'as' => 'api.importdetail.store',
        'uses' => 'ImportDetail\ImportDetailController@store',
    ]);

    Route::post('/{importdetail}/edit', [
        'as' => 'api.importdetail.update',
        'uses' => 'ImportDetail\ImportDetailController@update',
    ]);

});
