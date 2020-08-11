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


Route::middleware('auth:api')->prefix('dashboard')->group(function (){

    Route::get('/', [
        'as' => 'api.dashboard.index',
        'uses' => 'DashboardController@index',
    ]);

    Route::get('/test', [
        'as' => 'api.dashboard.test',
        'uses' => 'DashboardController@test',
    ]);
    Route::get('/chart1', [
        'as' => 'api.dashboard.chart1',
        'uses' => 'DashboardController@chart1',
    ]);
    Route::get('/chart2', [
        'as' => 'api.dashboard.chart2',
        'uses' => 'DashboardController@chart2',
    ]);
    Route::get('/chart3', [
        'as' => 'api.dashboard.chart3',
        'uses' => 'DashboardController@chart3',
    ]);
    Route::get('/chart4', [
        'as' => 'api.dashboard.chart4',
        'uses' => 'DashboardController@chart4',
    ]);
});
