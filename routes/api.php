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

## 公共接口
Route::post('wechat/auth','Api\WechatController@auth');
Route::post('wechat/logo','Api\WechatController@get_logo');

## 商品
Route::post('goods/list','Api\GoodsController@get_goods_list'); // 获取商品列表
Route::post('goods/info','Api\GoodsController@get_goods_info'); // 获取商品详情
Route::post('goods/search','Api\GoodsController@get_goods_search'); // 商品搜索
Route::post('goods/redeem_list','Api\GoodsController@get_redeem_list'); // 积分兑换
Route::post('goods/as_list','Api\GoodsController@get_as_list'); // 预售商品列表

## 用户
Route::post('user/info','Api\UserController@get_user_info');

## 签到
Route::post('sign/config','Api\SignController@get_sign_config');
Route::post('sign/user','Api\SignController@get_sign_user');
Route::post('sign/integral','Api\SignController@set_sign_integral');
Route::post('sign/detail','Api\SignController@get_sign_detail');

## 地址
Route::post('address/edit','Api\AddressController@set_address_info');
Route::post('address/list','Api\AddressController@get_address_list');
Route::post('address/default','Api\AddressController@get_address_default');
Route::post('address/detail','Api\AddressController@get_address_detail');

## 订单
Route::post('order/list','Api\OrderController@get_order_list');
Route::post('order/create','Api\OrderController@set_create_order');

