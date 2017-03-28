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
Route::get('sessions', 'SessionsController@show')->name('sessions');
Route::get('players', 'PlayerlistController@show')->name('players');
Route::get('map', 'MapController@show')->name('map');

Route::get('login', 'Auth\LoginController@show')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@view')->name('register');
Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::get('me/sessions', 'MySessionsController@show')->name('me.sessions');
Route::get('settings', 'Me\SettingsController@show')->name('settings');

Route::get('admin', 'AdminController@show')->name('admin');


