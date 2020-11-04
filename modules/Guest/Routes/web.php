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
Route::get('/', 'GuestController@index')->name('guest.home');
Route::get('/course', 'GuestController@course')->name('guest.course');
Route::get('/about-us', 'GuestController@about')->name('guest.about');
Route::get('/contact', 'GuestController@contact')->name('guest.contact');
Route::get('/teacher', 'GuestController@teacher')->name('guest.teacher');

Route::get('/checkin/{lesson}', 'GuestController@checkin')->name('checkin');
Route::post('/checkin/{lesson}', 'GuestController@handleCheckin')->name('checkin.submit');
//
Route::get('/regist-course/{grade}', 'GuestController@registGrade')->name('grade.register');
//
Route::get('/checkout/{lesson}', 'GuestController@checkout')->name('checkout');
Route::post('/checkout/{lesson}', 'GuestController@handlecheckout')->name('checkout.submit');

Route::get('/review/{lesson}', 'GuestController@review')->name('review');
Route::post('/review/{lesson}', 'GuestController@handleReview')->name('review.submit');
