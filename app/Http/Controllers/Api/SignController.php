<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Common\CommonController;
use App\Models\Integral\IntegralFlowModel;
use App\Models\Sign\SignConfigModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->sign_config_model = new SignConfigModel();
        $this->common = new CommonController();
        $this->integral_flow = new IntegralFlowModel();
    }

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

    /**
     * 获取签到配置列表
     * @param Request $request
     * @return false|string
     */
    public function get_sign_config(Request $request)
    {
        try{
             $where = $this->sign_config_model->getListWhere(['status'=>1]);
             $list  = $this->sign_config_model->getList($where);
             foreach ($list as $k => $v){
                 $list[$k]['date'] = $this->date_list[$v['date']];
             }
             return R('200','获取成功',$list);
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 获取签到用户信息
     * @param Request $request
     * @return false|string
     */
    public function get_sign_user(Request $request)
    {
        try{
            $headers = $request->header();

            // 验证token
            if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
                return R($verify_token_res['code'],$verify_token_res['msg']);
            }

            // 获取用户图片
            if (($get_user_images = json_decode($this->common->GetImagesById([$verify_token_res['data']['avatar_id']],$this->USER_IMAGE_TYPE),true)) && $get_user_images['code'] != '200'){
                return R($get_user_images['code'],$get_user_images['msg']);
            }

            // 获取用户积分
            if (($get_user_integral = json_decode($this->common->GetUserIntegral($verify_token_res['data']['id']),true)) && $get_user_integral['code'] != '200'){
                return R($get_user_images['code'],$get_user_images['msg']);
            }

            // 获取用户当天的签到记录
            if (($get_user_sign = json_decode($this->common->GetUserSignInfo($verify_token_res['data']['id']),true)) && $get_user_sign['code'] != '200' ){
                return R($get_user_sign['code'],$get_user_sign['msg']);
            }

            // 获取用户签到总数和最后一次签到记录
            if (($get_user_sign_list = json_decode($this->common->GetUserSignList($verify_token_res['data']['id']),true)) && $get_user_sign_list['code'] != '200' ){
                return R($get_user_sign_list['code'],$get_user_sign_list['msg']);
            }

            $user_info = $verify_token_res['data'];
            $user_info['avatar_url'] = $get_user_images['data'][$this->USER_IMAGE_TYPE]['src'];
            $user_info['integral_total'] = isset($get_user_integral['data']['total']) && !empty($get_user_integral['data']['total']) ? $get_user_integral['data']['total'] : 0;
            $user_info['user_sign_status'] = empty($get_user_sign['data']) ? 0 : 1;
            $user_info['sum_sgin_day'] = $get_user_sign_list['count'];
            $user_info['sign_num'] = isset($get_user_sign_list['data']) && !empty($get_user_sign_list['data']) ? $get_user_sign_list['data'][0]['target_id'] : 0;

            return R('200','查询成功',$user_info);
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 用户签到，更新积分流水以及积分主表
     * @param Request $request
     * @return false|string
     */
    public function set_sign_integral(Request $request)
    {
        $headers = $request->header();
        $params  = $request->post();
        // 验证token
        if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
            return R($verify_token_res['code'],$verify_token_res['msg']);
        }
        if (empty($params['index']) || !isset($params['index'])){
            return R('100030');
        }

        // 开启事务
        DB::beginTransaction();

        // 验证用户当前时间是否签到过 | Y-m-d
        if (($get_user_sign = json_decode($this->common->GetUserSignInfo($verify_token_res['data']['id']),true)) && $get_user_sign['code'] != '200'){
            return R($get_user_sign['code'],$get_user_sign['msg']);
        }

        if (!empty($get_user_sign['data'])){
            return R('100033');
        }

        // 查询签到配置表，获取签到对应的积分
        $get_sign_where = $this->sign_config_model->getListWhere(['status'=>1,'date'=>intval($params['index'])]);
        $get_sign_info  = $this->sign_config_model->getOne($get_sign_where);
        $sign_reward = empty($get_sign_info) || !isset($get_sign_info['sign_reward']) ? 0 :$get_sign_info['sign_reward'];

        // 创建积分流水
        if (($create_flow_res = json_decode($this->common->SetIntegralFlow($verify_token_res['data']['id'],1,$params['index'],$sign_reward),true)) && $create_flow_res['code'] != '200' ){
            DB::rollBack();
            return R($create_flow_res['code'],$create_flow_res['msg']);
        }

        // 创建积分账户或更新账户
        if (($create_integral_res = json_decode($this->common->SetIntegral($verify_token_res['data']['id'],$sign_reward),true)) && $create_integral_res['code'] != '200'){
            DB::rollBack();
            return R($create_integral_res['code'],$create_integral_res['msg']);
        }

        DB::commit();
        return R('200','签到成功',['integral'=>$sign_reward]);
    }

    public function get_sign_detail(Request $request)
    {
        $headers = $request->header();
        $params  = $request->post();
        // 验证token
        if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
            return R($verify_token_res['code'],$verify_token_res['msg']);
        }
        $user_info = $verify_token_res['data'];
        // 验证参数
        if (empty($params['page']) || !isset($params['page'])){
            return R('100025');
        }
        if (empty($params['limit']) || !isset($params['limit'])){
            return R('100034');
        }
        if( ($sign_list_res = json_decode($this->common->GetUserSignList($user_info['id'],$params['page'],$params['limit']),true)) && $sign_list_res['code']!='200' ){
            return R($sign_list_res['code'],$sign_list_res['msg']);
        }

        foreach ($sign_list_res['data'] as $k => $v){
            $sign_list_res['data'][$k]['title'] = '用户签到详情';
        }

        return R('200','查询成功',$sign_list_res['data'],$sign_list_res['count']);
    }
}
