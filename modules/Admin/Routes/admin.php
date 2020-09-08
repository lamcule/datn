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

Route::get('/', [
    'as' => 'admin.index',
    'uses' => 'HomeController@index',

])->middleware('permission:admin.index');

Route::group(['prefix' =>'/schedule'], function (){
    Route::get('/lessons', [
        'as' => 'admin.schedule.lesson',
        'uses' => 'HomeController@lesson',

    ])->middleware('permission:admin.schedule.lesson');
});

Route::group(['prefix' =>'/profile'], function (){
    Route::get('edit', [
        'as' => 'admin.profile.edit',
        'uses' => 'HomeController@index',

    ])->middleware('permission:admin.profile.edit');
});

Route::get('/checkin-qr/{lesson}', [
    'as' => 'admin.checkinqr',
    'uses' => 'HomeController@checkinQR',

])->middleware('permission:admin.checkinqr');

Route::get('/checkout-qr/{lesson}', [
    'as' => 'admin.checkoutqr',
    'uses' => 'HomeController@checkoutQR',

])->middleware('permission:admin.checkoutqr');

Route::get('/review-qr/{lesson}', [
    'as' => 'admin.reviewqr',
    'uses' => 'HomeController@reviewQR',

])->middleware('permission:admin.reviewqr');


Route::group(['prefix' =>'/auth'], function (){
    // user
    Route::post('/users', [
        'as' => 'admin.auth.users.destroy',
        'uses' => 'Auth\UserController@destroy',

    ])->middleware('permission:admin.auth.users.destroy');
    Route::get('/users', [
        'as' => 'admin.auth.users.index',
        'uses' => 'Auth\UserController@index',

    ])->middleware('permission:admin.auth.users.index');
    Route::get('users/create', [
        'as' => 'admin.auth.users.create',
        'uses' => 'Auth\UserController@create',
    ])->middleware('permission:admin.auth.users.create');

    Route::get('users/{user}/edit', [
        'as' => 'admin.auth.users.edit',
        'uses' => 'Auth\UserController@edit',
    ])->middleware('permission:admin.auth.users.edit');
    // permission
    Route::get('/permissions', [
        'as' => 'admin.auth.permissions.index',
        'uses' => 'Auth\PermissionController@index',

    ])->middleware('permission:admin.auth.permissions.index');
    Route::get('permissions/create', [
        'as' => 'admin.auth.permissions.create',
        'uses' => 'Auth\PermissionController@create',
    ])->middleware('permission:admin.auth.permissions.create');

    Route::get('permissions/{permission}/edit', [
        'as' => 'admin.auth.permissions.edit',
        'uses' => 'Auth\PermissionController@edit',
    ])->middleware('permission:admin.auth.permissions.edit');

    // role
    Route::get('/roles', [
        'as' => 'admin.auth.roles.index',
        'uses' => 'Auth\RoleController@index',

    ])->middleware('permission:admin.auth.roles.index');
    Route::get('roles/create', [
        'as' => 'admin.auth.roles.create',
        'uses' => 'Auth\RoleController@create',
    ])->middleware('permission:admin.auth.roles.create');

    Route::get('roles/{role}/edit', [
        'as' => 'admin.auth.roles.edit',
        'uses' => 'Auth\RoleController@edit',
    ])->middleware('permission:admin.auth.roles.edit');
});
Route::group(['prefix' => '/media'], function ( ) {
    Route::get('media', [
        'as' => 'admin.media.index',
        'uses' => 'Media\MediaController@index',
    ])->middleware('permission:admin.media.index');
    Route::get('media/create', [
        'as' => 'admin.media.create',
        'uses' => 'Media\MediaController@create',
    ])->middleware('permission:admin.media.create');
    Route::post('media', [
        'as' => 'admin.media.store',
        'uses' => 'Media\MediaController@store',
    ])->middleware('permission:admin.media.store');
    Route::get('media/{media}/edit', [
        'as' => 'admin.media.edit',
        'uses' => 'Media\MediaController@edit',
    ])->middleware('permission:admin.media.edit');
    Route::put('media/{media}', [
        'as' => 'admin.media.update',
        'uses' => 'Media\MediaController@update',
    ])->middleware('permission:admin.media.update');
    Route::delete('media/{media}', [
        'as' => 'admin.media.destroy',
        'uses' => 'Media\MediaController@destroy',
    ])->middleware('permission:admin.media.destroy');


});

require_once 'admin/student.php';
require_once 'admin/course.php';
require_once 'admin/grade.php';
require_once 'admin/lesson.php';
require_once 'admin/report.php';
require_once 'admin/teacher.php';
require_once 'admin/review.php';
require_once 'admin/studentimport.php';
require_once 'admin/banner.php';

