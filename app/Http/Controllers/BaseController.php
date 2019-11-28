<?php
namespace App\Http\Controllers;

use App\Models\User\UserExtensionModel;
use App\Models\User\UserModel;

class BaseController
{

    public function token_verify($headers = array())
    {
        $user_extension_model = new UserExtensionModel();
        $user_model = new UserModel();
        if(!is_array($headers)) return R('0','请求头解析失败');
        if(empty($headers)) return R('0','请求参数为空');
        if(empty($headers['token'][0]) || !isset($headers['token'][0])) return R('0','Token获取失败');

        $user_extension_where = $user_extension_model->getListWhere(['status'=>1,'token'=>trim($headers['token'][0])]);
        $user_extension_res = $user_extension_model->getOne($user_extension_where);

        if(!isset($user_extension_res['user_id']) || empty($user_extension_res['user_id'])) return R('0','Token不存在');
        $user_where = $user_model->getListWhere(['id'=>$user_extension_res['user_id'],'status'=>1]);
        $user_res = $user_model->getOne($user_where);

        $response = !empty($user_res) ? $user_res : [];
        return R('200','获取成功',$response);
    }
}
