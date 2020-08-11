<?php

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

Route::middleware('auth:api')->prefix('review')->group(function (){

    Route::get('/', [
        'as' => 'api.userreview.index',
        'uses' => 'UserReview\UserReviewController@index',
    ]);
    Route::get('/{userreview}', [
        'as' => 'api.review.index',
        'uses' => 'Review\ReviewController@index',
    ]);

});
