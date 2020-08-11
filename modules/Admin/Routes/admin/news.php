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

Route::group(['prefix' =>'/news'], function (){

    // country
    Route::get('/', [
        'as' => 'admin.news.index',
        'uses' => 'News\NewsController@index',

    ])->middleware('permission:admin.news.index');

    Route::get('/create', [
        'as' => 'admin.news.create',
        'uses' => 'News\NewsController@create',
    ])->middleware('permission:admin.news.create');

    Route::get('/{news}/edit/{locale?}', [
        'as' => 'admin.news.edit',
        'uses' => 'News\NewsController@edit',
    ])->middleware('permission:admin.news.create');

});