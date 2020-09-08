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


Route::middleware('auth:api')->prefix('auth')->group(function (){
    Route::get('/permissions', [
        'as' => 'api.auth.permissions.index',
        'uses' => 'Auth\PermissionController@index',

    ]);
    Route::delete('permissions/{permission}', [
        'as' => 'api.auth.permissions.destroy',
        'uses' => 'Auth\PermissionController@destroy',

    ]);
    Route::post('permissions', [
        'as' => 'api.auth.permissions.store',
        'uses' => 'Auth\PermissionController@store',

    ]);
    Route::get('permissions/{permission}', [
        'as' => 'api.auth.permissions.find',
        'uses' => 'Auth\PermissionController@find',

    ]);
    Route::post('permissions/{permission}/edit', [
        'as' => 'api.auth.permissions.update',
        'uses' => 'Auth\PermissionController@update',

    ]);
    //roles

    Route::get('/roles/all', [
        'as' => 'api.auth.roles.all',
        'uses' => 'Auth\RoleController@all',

    ]);
    Route::get('/roles', [
        'as' => 'api.auth.roles.index',
        'uses' => 'Auth\RoleController@index',

    ]);
    Route::get('/roles', [
        'as' => 'api.auth.roles.index',
        'uses' => 'Auth\RoleController@index',

    ]);
    Route::delete('roles/{role}', [
        'as' => 'api.auth.roles.destroy',
        'uses' => 'Auth\RoleController@destroy',

    ]);
    Route::post('roles', [
        'as' => 'api.auth.roles.store',
        'uses' => 'Auth\RoleController@store',

    ]);
    Route::get('roles/{role}', [
        'as' => 'api.auth.roles.find',
        'uses' => 'Auth\RoleController@find',

    ]);
    Route::post('roles/{role}/edit', [
        'as' => 'api.auth.roles.update',
        'uses' => 'Auth\RoleController@update',

    ]);
    Route::post('roles/{role}/assign-permission', [
        'as' => 'api.auth.roles.assignPermissions',
        'uses' => 'Auth\RoleController@assignPermissions',

    ]);
    Route::post('roles/{role}/remove-permission', [
        'as' => 'api.auth.roles.removePermissions',
        'uses' => 'Auth\RoleController@removePermissions',

    ]);
    // users
    Route::get('users', [
        'as' => 'api.auth.users.index',
        'uses' => 'Auth\UserController@index',

    ]);
    Route::delete('users/{user}', [
        'as' => 'api.auth.users.destroy',
        'uses' => 'Auth\UserController@destroy',

    ]);

    Route::get('users/has-permissions', [
        'as' => 'api.auth.users.hasPermissions',
        'uses' => 'Auth\UserController@hasPermissions',
    ]);

    Route::get('users/{user}', [
        'as' => 'api.auth.users.find',
        'uses' => 'Auth\UserController@find',
    ]);
    Route::post('users/{user}/edit', [
        'as' => 'api.auth.users.update',
        'uses' => 'Auth\UserController@update',

    ]);
    Route::post('users/{user}/change-status', [
        'as' => 'api.auth.users.changeStatus',
        'uses' => 'Auth\UserController@changeStatus',

    ]);
    Route::post('users', [
        'as' => 'api.auth.users.store',
        'uses' => 'Auth\UserController@store',

    ]);

    Route::post('users/{user}/change-password', [
        'as' => 'api.auth.users.change-password',
        'uses' => 'Auth\UserController@changePassword',

    ]);

});
require_once 'api/student.php';
require_once 'api/course.php';
require_once 'api/area.php';
require_once 'api/grade.php';
require_once 'api/lesson.php';
require_once 'api/userlesson.php';
require_once 'api/report.php';
require_once 'api/teacher.php';

require_once 'api/dashboard.php';

require_once 'api/review.php';
require_once 'api/studentimport.php';
require_once 'api/question.php';
require_once 'api/banner.php';
