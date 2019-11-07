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

Route::get('/','LoginController@index')->name('login');

Route::get('/home/index','HomeController@index')->name('home.index');
Route::get('/home/welcome','HomeController@welcome')->name('home.welcome');

//Route::get('/user/show','UserController@show')->name('user.show');
Route::any('/user/list','UserController@lists')->name('user.list');
Route::post('/user/create','UserController@create')->name('user.create');
Route::post('/user/edit/{id}','UserController@edit')->name('user.edit');

Route::any('/trends/list','TrendsController@trendsList');


Route::get('/menu/index','MenuController@index')->name('menu.index');
Route::any('/menu/list','MenuController@lists')->name('menu.list');
Route::any('/menu/create','MenuController@create')->name('menu.create');


Route::any('/sp/list','SpController@lists')->name('sp.list');
