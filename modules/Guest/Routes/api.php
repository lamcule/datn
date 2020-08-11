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
Route::group(['prefix' => 'guest'], function () {
    Route::get('/questions', 'PublicController@questions')->name('api.guest.question');
    Route::get('/provinces', 'AreaController@provinces')->name('api.guest.province');
    Route::get('/districts', 'AreaController@districts')->name('api.guest.district');
    Route::get('/phoenixes', 'AreaController@phoenixes')->name('api.guest.phoenix');
    Route::get('/grade/{grade}', 'GradeController@find')->name('apife.grade.find');
    Route::post('/regist-grade/{grade}', 'PublicController@registGrade')->name('api.guest.registGrade');
    Route::post('/regist-grade-no-account/{grade}', 'PublicController@registGradeNoAccount')->name('api.guest.registGradeNoAccount');
    Route::get('/lesson/{lesson}', 'PublicController@getLesson')->name('api.lesson.find');
    Route::post('/review/{lesson}', 'PublicController@handleReview')->name('api.review');

});
