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

Route::get('/', 'HomeController@index')->name('home');
Route::get('players', 'PlayerlistController@show')->name('players');
Route::get('user/{user}', 'UserController@view')->name('user');
Route::get('map', 'MapController@show')->name('map');

Route::get('login', 'Auth\LoginController@show')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@view')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::get('me/sessions', 'Me\MySessionsController@show')->name('me.sessions');
Route::get('settings', 'Me\SettingsController@show')->name('settings');

Route::match(['get', 'post'], 'session/create', 'SessionController@create')->name('session.create');
Route::get('sessions', 'SessionController@viewList')->name('sessions');
Route::get('session/{id}', 'SessionController@view')->name('session');
Route::match(['get', 'post'], 'session/{id}/edit', 'SessionController@edit')->name('session.edit');
Route::post('session/{id}/signin', 'SessionController@signin')->name('session.signin');
Route::post('session/{id}/signout', 'SessionController@signout')->name('session.signout');
Route::match(['get', 'post'], 'session/{id}/delete', 'SessionController@delete')->name('session.delete');

Route::get('admin', 'AdminController@show')->name('admin');
Route::get('admin/users', 'AdminController@users')->name('admin.users');
Route::match(['get', 'post'], 'admin/user/{user}', 'AdminController@editUser')->name('admin.users.edit');
Route::get('admin/announcements', 'AdminController@announcements')->name('admin.announcements');

Route::get('/announcement/{id}', 'AnnouncementController@show')->name('announcement.show');
Route::get('/announcement/{id}/create', 'AnnouncementController@create')->name('announcement.create');
Route::get('/announcement/{id}/edit', 'AnnouncementController@edit')->name('announcement.edit');
Route::get('/announcement/{id}/delete', 'AnnouncementController@delete')->name('announcement.delete');


