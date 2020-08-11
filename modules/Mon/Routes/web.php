<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login.admin');
Route::post('login', 'Auth\LoginController@login')->name('login.submit');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/forgot', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forgot');
Route::post('/forgot', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgot.submit');
Route::get('/reset', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

