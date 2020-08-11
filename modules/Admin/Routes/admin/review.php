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

Route::group(['prefix' =>'/review'], function (){

    // country
    Route::get('/', [
        'as' => 'admin.userreview.index',
        'uses' => 'UserReview\UserReviewController@index',

    ])->middleware('permission:admin.userreview.index');

    Route::get('/{userreview}', [
        'as' => 'admin.review.index',
        'uses' => 'Review\ReviewController@index',

    ])->middleware('permission:admin.review.index');

    Route::get('/list/download', [
        'as' => 'admin.review.download',
        'uses' => 'UserReview\UserReviewController@download',
    ]);
});
