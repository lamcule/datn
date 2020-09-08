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


Route::middleware('auth:api')->prefix('banner')->group(function () {
    Route::get('/', [
        'as' => 'api.banner.index',
        'uses' => 'Banner\BannerController@index',

    ]);
    Route::get('/all', [
        'as' => 'api.banner.all',
        'uses' => 'Banner\BannerController@all',

    ]);
    Route::delete('/{banner}', [
        'as' => 'api.banner.destroy',
        'uses' => 'Banner\BannerController@destroy',

    ])->middleware('permission:admin.banner.destroy');
    Route::post('/store', [
        'as' => 'api.banner.store',
        'uses' => 'Banner\BannerController@store',

    ]);
    Route::get('/{banner}/{locale?}', [
        'as' => 'api.banner.find',
        'uses' => 'Banner\BannerController@find',

    ]);
    Route::post('/{banner}/edit', [
        'as' => 'api.banner.update',
        'uses' => 'Banner\BannerController@update',

    ]);
});


