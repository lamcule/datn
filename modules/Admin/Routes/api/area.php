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


Route::middleware('auth:api')->prefix('provinces')->group(function (){

    Route::get('/', [
        'as' => 'api.province.index',
        'uses' => 'Province\ProvinceController@index',
    ]);
    Route::get('/all', [
        'as' => 'api.province.all',
        'uses' => 'Province\ProvinceController@all',
    ]);

    Route::get('/{province}', [
        'as' => 'api.province.find',
        'uses' => 'Province\ProvinceController@find',
    ]);

    Route::delete('/{province}', [
        'as' => 'api.province.destroy',
        'uses' => 'Province\ProvinceController@destroy',
    ]);

    Route::post('/', [
        'as' => 'api.province.store',
        'uses' => 'Province\ProvinceController@store',
    ]);

    Route::post('/{province}/edit', [
        'as' => 'api.province.update',
        'uses' => 'Province\ProvinceController@update',
    ]);

});


Route::middleware('auth:api')->prefix('districts')->group(function (){

    Route::get('/', [
        'as' => 'api.district.index',
        'uses' => 'District\DistrictController@index',
    ]);
    Route::get('/all', [
        'as' => 'api.district.all',
        'uses' => 'District\DistrictController@all',
    ]);

    Route::get('/{district}', [
        'as' => 'api.district.find',
        'uses' => 'District\DistrictController@find',
    ]);

    Route::delete('/{district}', [
        'as' => 'api.district.destroy',
        'uses' => 'District\DistrictController@destroy',
    ]);

    Route::post('/', [
        'as' => 'api.district.store',
        'uses' => 'District\DistrictController@store',
    ]);

    Route::post('/{district}/edit', [
        'as' => 'api.district.update',
        'uses' => 'District\DistrictController@update',
    ]);

});



Route::middleware('auth:api')->prefix('phoenixes')->group(function (){

    Route::get('/', [
        'as' => 'api.phoenix.index',
        'uses' => 'Phoenix\PhoenixController@index',
    ]);
    Route::get('/all', [
        'as' => 'api.phoenix.all',
        'uses' => 'Phoenix\PhoenixController@all',
    ]);
    Route::get('/{phoenix}', [
        'as' => 'api.phoenix.find',
        'uses' => 'Phoenix\PhoenixController@find',
    ]);

    Route::delete('/{phoenix}', [
        'as' => 'api.phoenix.destroy',
        'uses' => 'Phoenix\PhoenixController@destroy',
    ]);

    Route::post('/', [
        'as' => 'api.phoenix.store',
        'uses' => 'Phoenix\PhoenixController@store',
    ]);

    Route::post('/{phoenix}/edit', [
        'as' => 'api.phoenix.update',
        'uses' => 'Phoenix\PhoenixController@update',
    ]);

});
