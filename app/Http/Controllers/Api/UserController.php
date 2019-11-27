<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Common\CommonController;
use Illuminate\Http\Request;

class UserController
{
    protected  $USER_IMAGE_TYPE = '3';  // 图片类型: 3 = 用户头像

    public function __construct()
    {
        $this->Common = new CommonController();
    }

    public function get_user_info(Request $request)
    {
        try{
            $params = $request->post();
            if(empty($params) && is_array($params)){
                return R('411');
            }
            if(empty($params['id']) || !isset($params['id']) || intval($params['id']) <= 0){
                return R('100027');
            }
            if(($get_user_info = json_decode($this->Common->GetUserInfo($params['id']),true)) && $get_user_info['code'] != '200'){
                return R($get_user_info['code'],$get_user_info['msg']);
            }
            $data = $get_user_info['data'];
            if(empty($data)){
                return R('200','获取用户信息成功',array());
            }
            if(($get_user_images = json_decode($this->Common->GetImagesById([$data['avatar_id']],$this->USER_IMAGE_TYPE),true)) && $get_user_images['code'] != '200'){
                return R($get_user_images['code'],$get_user_images['msg']);
            }
            $response['user_info'] = $data;
            $response['user_info']['avatar_url'] = $get_user_images['data'][$this->USER_IMAGE_TYPE]['src'];

            return R('200','获取用户信息成功',$response);

        }catch (\Exception $e){
            return R('500','错误信息:'.$e->getMessage());
        }
    }
}
