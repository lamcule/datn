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

Route::group(['prefix' =>'/banner'], function (){

    Route::get('/', [
        'as' => 'admin.banner.index',
        'uses' => 'Banner\BannerController@index',

    ])->middleware('permission:admin.banner.index');

    Route::get('/create', [
        'as' => 'admin.banner.create',
        'uses' => 'Banner\BannerController@create',
    ])->middleware('permission:admin.banner.create');

    Route::get('/{banner}/edit/{locale?}', [
        'as' => 'admin.banner.edit',
        'uses' => 'Banner\BannerController@edit',
    ])->middleware('permission:admin.banner.edit');

    Route::post('/', [
        'as' => 'admin.banner.destroy',
        'uses' => 'Banner\BannerController@destroy',

    ])->middleware('permission:admin.banner.destroy');
});
