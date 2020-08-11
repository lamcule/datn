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


Route::middleware('auth:api')->prefix('reports')->group(function (){

    Route::get('/student', [
        'as' => 'api.report.student',
        'uses' => 'Report\ReportController@student',
    ]);
    Route::get('/grades', [
        'as' => 'api.report.grades',
        'uses' => 'Report\ReportController@grades',
    ]);
    Route::get('/grades/{grade}', [
        'as' => 'api.report.grade.detail',
        'uses' => 'Report\ReportController@gradeDetail',
    ]);
    Route::get('/grades/review/{grade}', [
        'as' => 'api.report.grade.review',
        'uses' => 'Report\ReportController@sumRateByGrade',
    ]);
    Route::get('/grades/review/{grade}/detail', [
        'as' => 'api.report.grade.reviewDetail',
        'uses' => 'Report\ReportController@gradeReviewDetail',
    ]);
    Route::get('/student-activity', [
        'as' => 'api.report.studentActivity',
        'uses' => 'Report\ReportController@studentActivity',
    ]);
    Route::get('/review-history', [
        'as' => 'api.report.reviewHistory',
        'uses' => 'Report\ReportController@reviewHistory',
    ]);
	Route::get('/student-lesson', [
		'as' => 'api.report.studentLesson',
		'uses' => 'Report\ReportController@studentLesson',
	]);

	Route::get('/course-activity', [
		'as' => 'api.report.courseActivity',
		'uses' => 'Report\ReportController@courseActivity',
	]);
});
