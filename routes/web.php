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
    return view('Admin.user.login');
});


//Route::get('/login','Admin\UserController@login');
Route::get('home/index',function(){
    return view('Admin.home.index');
});
//Route::post('user/login','Admin\User');

//Route::group('user',function (){
//    Route::post('list','Admin\UserController@UserList');
//});



Route::post('user/login','Admin\UserController@login');

// 用户管理相关路由
Route::prefix('user')->group(function () {
    Route::any('UserList','Admin\UserController@UserList');
});

// 内容管理相关路由
Route::prefix('article')->group(function () {
    Route::any('ArticleList','Admin\ArticleCOntroller@getArticleList');
});