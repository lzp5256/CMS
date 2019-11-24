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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test',function (){
    return 1111;
})->middleware('apiAuth');

## 微信
Route::post('wechat/auth','Api\WechatController@auth');

## 商品
Route::post('goods/list','Api\GoodsController@get_goods_list');
Route::post('goods/info','Api\GoodsController@get_goods_info');
Route::post('goods/search','Api\GoodsController@get_goods_search');
