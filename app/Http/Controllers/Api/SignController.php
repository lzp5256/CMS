<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Common\CommonController;
use App\Models\Sign\SignConfigModel;
use Illuminate\Http\Request;

class SignController extends BaseController
{
    protected $date_list = [
        '1' => '第一天',
        '2' => '第二天',
        '3' => '第三天',
        '4' => '第四天',
        '5' => '第五天',
        '6' => '第六天',
        '7' => '第七天',
    ];

    protected  $USER_IMAGE_TYPE = '3';  // 图片类型: 3 = 用户头像
    public function __construct(Request $request)
    {
        $this->sign_config_model = new SignConfigModel();
        $this->common = new CommonController();
    }

    public function get_sign_config(Request $request)
    {
        try{
             $where = $this->sign_config_model->getListWhere(['status'=>1]);
             $list  = $this->sign_config_model->getList($where);

             return R('200','获取成功',$list);
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    public function get_sign_user(Request $request)
    {
        try{
            $headers = $request->header();

            if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
                return R($verify_token_res['code'],$verify_token_res['msg']);
            }
            if (($get_user_images = json_decode($this->common->GetImagesById([$verify_token_res['data']['avatar_id']],$this->USER_IMAGE_TYPE),true)) && $get_user_images['code'] != '200'){
                return R($get_user_images['code'],$get_user_images['msg']);
            }
            if (($get_user_integral = json_decode($this->common->GetUserIntegral($verify_token_res['data']['id']),true)) && $get_user_integral['code'] != '200'){
                return R($get_user_images['code'],$get_user_images['msg']);
            }
            if (($get_user_sign = json_decode($this->common->GetUserSignInfo($verify_token_res['data']['id']),true)) && $get_user_sign['code'] != '200' ){
                return R($get_user_sign['code'],$get_user_sign['msg']);
            }
            $user_info = $verify_token_res['data'];
            $user_info['avatar_url'] = $get_user_images['data'][$this->USER_IMAGE_TYPE]['src'];
            $user_info['integral_total'] = isset($get_user_integral['data']['total']) && !empty($get_user_integral['data']['total']) ? $get_user_integral['data']['total'] : 0;
            $user_info['user_sign_status'] = empty($get_user_sign['data']) ? 0 : 1;

            return R('200','查询成功',$user_info);
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }
}
