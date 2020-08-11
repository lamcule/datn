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

Route::group(['prefix' =>'/reports'], function (){

    // country
    Route::get('/student', [
        'as' => 'admin.report.student',
        'uses' => 'Report\ReportController@student',

    ])->middleware('permission:admin.report.student');
    Route::get('/student/download', [
        'as' => 'admin.report.downloadStudent',
        'uses' => 'Report\ReportController@downloadStudent',

    ])->middleware('permission:admin.report.downloadStudent');

    Route::get('/grades', [
        'as' => 'admin.report.grades',
        'uses' => 'Report\ReportController@grades',

    ])->middleware('permission:admin.report.grades');
    Route::get('/grades/{grade}', [
        'as' => 'admin.report.grade.detail',
        'uses' => 'Report\ReportController@grade',

    ])->middleware('permission:admin.report.grade.detail');
    Route::get('/grades/summary/download', [
        'as' => 'admin.report.grade.downloadGradeSummary',
        'uses' => 'Report\ReportController@downloadGradeSummary',
    ]);
    Route::get('/grades/{grade}/download', [
        'as' => 'admin.report.grade.downloadGradeReview',
        'uses' => 'Report\ReportController@downloadGradeReview',
    ]);

    Route::get('/student-activity', [
        'as' => 'admin.report.studentActivity',
        'uses' => 'Report\ReportController@studentActivity',
    ])->middleware('permission:admin.report.studentActivity');

    Route::get('/student-activity/download', [
        'as' => 'admin.report.downloadStudentActivity',
        'uses' => 'Report\ReportController@downloadStudentActivity',
    ])->middleware('permission:admin.report.downloadStudentActivity');

    Route::get('/review-history', [
        'as' => 'admin.report.reviewHistory',
        'uses' => 'Report\ReportController@reviewHistory',
    ])->middleware('permission:admin.report.reviewHistory');

    Route::get('/review-history/download', [
        'as' => 'admin.report.downloadReviewHistory',
        'uses' => 'Report\ReportController@downloadReviewHistory',
    ])->middleware('permission:admin.report.downloadReviewHistory');

    Route::get('/grades/{grade}/summary/download', [
        'as' => 'admin.report.grade.downloadGradeDetail',
        'uses' => 'Report\ReportController@downloadGradeDetail',
    ]);

	Route::get('/student-lesson', [
		'as' => 'admin.report.studentLesson',
		'uses' => 'Report\ReportController@studentLesson',
	])->middleware('permission:admin.report.studentLesson');
	Route::get('/student-lesson/download', [
		'as' => 'admin.report.downloadStudentLesson',
		'uses' => 'Report\ReportController@downloadStudentLesson',
	])->middleware('permission:admin.report.downloadStudentLesson');


	Route::get('/course-activity', [
		'as' => 'admin.report.courseActivity',
		'uses' => 'Report\ReportController@courseActivity',
	])->middleware('permission:admin.report.courseActivity');
	Route::get('/course-activity/download', [
		'as' => 'admin.report.downloadCourseActivity',
		'uses' => 'Report\ReportController@downloadCourseActivity',
	])->middleware('permission:admin.report.downloadCourseActivity');

});
