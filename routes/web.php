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

## 公共接口
Route::post('/common/upload','UploadController@upload')->name('common.upload');
Route::post('/common/e_upload','UploadController@e_upload')->name('common.e_upload'); //富文本上传

## 登录接口
Route::get('/','LoginController@index')->name('login');

## 首页接口
Route::get('/home/index','HomeController@index')->name('home.index');
Route::get('/home/welcome','HomeController@welcome')->name('home.welcome');

## 用户接口
Route::any('/user/list','UserController@lists')->name('user.list');
Route::post('/user/create','UserController@create')->name('user.create');
Route::post('/user/edit/{id}','UserController@edit')->name('user.edit');

##
Route::any('/trends/list','TrendsController@trendsList');

## 菜单接口
Route::get('/menu/index','MenuController@index')->name('menu.index');
Route::any('/menu/list','MenuController@lists')->name('menu.list');
Route::any('/menu/create','MenuController@create')->name('menu.create');
Route::post('/menu/del','MenuController@del')->name('menu.del');

## 服务商接口
Route::any('/sp/list','SpController@lists')->name('sp.list');

## 商品接口
Route::any('/goods/list','GoodsController@lists')->name('goods.list');
Route::any('/goods/goods_create','GoodsController@goods_create')->name('goods.goodscreate');
Route::any('/goods/type_list','GoodsController@goods_type_list')->name('goods.typelist');
Route::any('/goods/type_create','GoodsController@goods_type_create')->name('goods.typecreate');
Route::any('/goods/brand_list','GoodsController@goods_brand_list')->name('goods.brandlist');
Route::any('/goods/brand_create','GoodsController@goods_brand_create')->name('goods.brandcreate');
Route::get('/goods/goods_edit_view/id/{id}','GoodsController@goods_edit_view')->name('goods.editview');
Route::post('/goods/goods_unshelves','GoodsController@goods_unshelves')->name('goods.unshelves');

## 海报管理
Route::any('/poster/poster_list','PosterController@poster_list')->name('poster.list');
Route::any('/poster/poster_create','PosterController@poster_create')->name('poster.create');
