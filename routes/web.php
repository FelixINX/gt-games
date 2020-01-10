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

Route::get('/', function () {
    return view('app');
});

// Auth routes
Auth::routes();
Route::get('/login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('/login/callback', 'Auth\LoginController@handleGoogleCallback');
Route::get('/logout', function () {
    return view('auth.logout');
});
Route::get('/register/request', 'Auth\RegisterController@request')->name('request.show');
Route::post('/register/invitation', 'Admin\InvitationController@store')->name('request.store');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('hasInvitation');

// Admin
Route::get('/admin', 'Admin\HomeController@index')->name('admin.home')->middleware('auth');
Route::resource('/admin/invitations', 'Admin\InvitationController')->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home');
