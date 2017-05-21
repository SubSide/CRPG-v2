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

// Static stuff
Route::get('/', 'HomeController@index')->name('home');
Route::get('users', 'PlayerController@viewList')->name('users');
Route::get('user/{user}', 'PlayerController@viewProfile')->name('user');
Route::get('map', 'MapController@show')->name('map');

// Authentication
Route::get('login', 'Auth\LoginController@show')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@view')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('register/succesful', 'Auth\RegisterController@registrationSuccesful')->name('register.successful');
Route::get('confirm/{token}', 'Auth\RegisterController@confirm')->name('register.confirm');

// Settings
Route::get('me/sessions', 'Me\MySessionsController@show')->name('me.sessions');
Route::match(['get', 'post'], 'settings', 'Me\SettingsController@settings')->name('settings');
Route::match(['get', 'post'], 'forgot/{token?}', 'Me\ForgotPasswordController@forgotPassword')->name('forgotpassword');

// Session stuff
Route::match(['get', 'post'], 'session/create', 'Management\SessionController@create')->name('session.create');
Route::get('sessions', 'Management\SessionController@viewList')->name('sessions');
Route::get('session/{id}', 'Management\SessionController@view')->name('session');
Route::match(['get', 'post'], 'session/{id}/edit', 'Management\SessionController@edit')->name('session.edit');
Route::post('session/{id}/signin', 'Management\SessionController@signin')->name('session.signin');
Route::post('session/{id}/signout', 'Management\SessionController@signout')->name('session.signout');
Route::match(['get', 'post'], 'session/{id}/delete', 'Management\SessionController@delete')->name('session.delete');

// Admin stuff
Route::get('admin', 'Management\AdminController@show')->name('admin');
Route::get('admin/users', 'Management\UserController@users')->name('admin.users');
Route::match(['get', 'post'], 'admin/user/{user}', 'Management\UserController@editUser')->name('admin.users.edit');
Route::get('admin/announcements', 'Management\AnnouncementController@showAdminList')->name('admin.announcements');

// Announcement stuff
Route::match(['get', 'post'], '/announcement/create', 'Management\AnnouncementController@create')->name('announcement.create');
Route::get('/announcement/{id}', 'Management\AnnouncementController@show')->name('announcement.show');
Route::match(['get', 'post'], '/announcement/{id}/edit', 'Management\AnnouncementController@edit')->name('announcement.edit');
Route::get('/announcement/{id}/delete', 'Management\AnnouncementController@delete')->name('announcement.delete');


