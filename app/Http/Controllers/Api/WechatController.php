<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Common\CommonController;
use App\Models\Poster\PosterModel;
use App\Models\Region\RegionModel;
use App\Models\User\UserExtensionModel;
use App\Models\User\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WechatController
{
    public function __construct(){
        $this->user_model = new UserModel();
        $this->region_model = new RegionModel();
        $this->user_extension_model = new UserExtensionModel();
        $this->CommonCtroller = new CommonController();
        $this->poster_model = new PosterModel();
    }

    /**
     * 微信登录
     * @param Request $request
     * @return false|string
     */
    public function auth(Request $request)
    {
        try{
            if(!empty($request->post())){
                $user_info = $request->post();
            }else{
                return R('300','参数解析异常');
            }
            $we_response = http_request(
                "https://api.weixin.qq.com/sns/jscode2session?appid="
                . config('app.wechat_appid')
                . "&secret=" . config('app.wechat_secret')
                . "&js_code=" . $user_info['code']['code']
                . "&grant_type=" . config('app.wechat_grant_type')
            );
            if(!($we_response = jsonDecode($we_response))){
                return R('300','微信返回参数解析失败');
            }

            if(isset($we_response['errcode']) && $we_response['errcode'] > 0 ){
                return R($we_response['errcode'],$we_response['errmsg']);
            }

            // 开启事务
            DB::beginTransaction();
            // 如果存在用户 && 主表数据为有效时，只更新有效期和token
            $where = $this->user_extension_model->getListWhere(['we_openid'=>$we_response['openid']]);
            $get_user_info = $this->user_extension_model->getOne($where);

            if(empty($get_user_info)){
                $save_user_data = [
                    'user_name' => $user_info['userInfo']['nickName'],
                    'user_gender' => $user_info['userInfo']['gender'],
                    'address'=>'',
                    'status' => 1,
                ];
                $save_user_res = $this->user_model->create($save_user_data);

                if(!$save_user_res){
                    DB::rollBack();
                    return R('0','创建用户失败');
                }

                $save_user_extension_data = [
                    'user_id'   => $save_user_res,
                    'we_openid' => $we_response['openid'],
                    'we_key'    => $we_response['session_key'],
                    'token'     => md5($we_response['openid'].$we_response['session_key']."muyao"),
                    'start_time'=> date('Y-m-d H:i:s'),
                    'end_time'  => date('Y-m-d H:i:s',strtotime('+7 day')),
                    'status'    => 1,
                ];
                $token = $save_user_extension_data['token'];
                $end_time = $save_user_extension_data['end_time'];
                $save_user_extension_res = $this->user_extension_model->create($save_user_extension_data);
                if (!$save_user_extension_res) {
                    DB::rollBack();
                    return R('0','创建用户扩展信息失败');
                }

                $create_image_res = $this->CommonCtroller->CreateImages($user_info['userInfo']['avatarUrl'],3,$save_user_res);
                if(( $create_image_res = json_decode($create_image_res,true))  && $create_image_res['code'] != '200' ){
                    DB::rollBack();
                    return R('0',$create_image_res['msg']);
                }

                $update_user_res = $this->user_model->updateById($save_user_res,['avatar_id'=>intval($create_image_res['data'])]);
                if(!$update_user_res){
                    DB::rollBack();
                    return R('0','更新头像失败');
                }

                if($save_user_res && $save_user_extension_res){
                    DB::commit();
                }
            }else{
                // 存在用户 && 判断时间是否超出有效期
                $user_id = $get_user_info['user_id'];
                $user_where = $this->user_model->getListWhere(['id'=>(int)$user_id]);
                $user = $this->user_model->getOne($user_where);
                if(strtotime($get_user_info['start_time']) <= time() &&  strtotime($get_user_info['end_time']) >= time()) {
                    $response['token'] = $get_user_info['token'];
                    $response['userInfo'] = $user;
                    $response['expires_time'] = $get_user_info['end_time'];
                    return R('200','获取成功',$response);
                }
                // 更新we_key,token,有效时间,用户信息
                $update_user_extension_data = [
                    'we_openid' => $we_response['openid'],
                    'we_key'    => $we_response['session_key'],
                    'token'     => md5($we_response['openid'].$we_response['session_key']."muyao"),
                    'start_time'=> date('Y-m-d H:i:s'),
                    'end_time'  => date('Y-m-d H:i:s',strtotime('+7 day')),
                ];
                $token = $update_user_extension_data['token'];
                $end_time = $update_user_extension_data['end_time'];
                $update_user_extension_res = $this->user_extension_model->updateById($get_user_info['id'],$update_user_extension_data);

                if(!$update_user_extension_res){
                    DB::rollBack();
                    return R('0','更新用户扩展表失败');
                }

                $update_user_data = [
                    'user_name' => $user_info['userInfo']['nickName'],
                    'user_gender' =>$user_info['userInfo']['gender'],
                ];

                $update_user_res = $this->user_model->updateById($user_id,$update_user_data);
                if(!$update_user_res){
                    DB::rollBack();
                    return R('0','更新用户信息失败');
                }

                $update_image_data = ['src' =>$user_info['userInfo']['avatarUrl']];
                $update_image_res = $this->CommonCtroller->UpdateImages($user['avatar_id'],$update_image_data);
                if(!$update_image_res){
                    DB::rollBack();
                    return R('0',$update_image_res['msg']);
                }

                if($update_user_extension_res && $update_user_res){
                    DB::commit();
                }
            }
            $user_id = isset($get_user_info) && !empty($get_user_info) ? $get_user_info['id'] : $save_user_res;
            $where   = $this->user_model->getListWhere(['id'=>(int)$user_id]);
            $info    = $this->user_model->getOne($where);
            $response = [
                'token' => $token,
                'userInfo' => $info,
                'expires_time' => $end_time,
            ];
            return R('200','获取成功',$response);
        }catch (\Exception $e){
            Log::info('微信登录异常,异常信息:'.$e->getMessage());
            return R('500',$e->getMessage());
        }

    }

    /**
     * 获取logo
     * @param Request $request
     * @return false|string
     */
    public function get_logo(Request $request)
    {
        try{
            $res = [
                'src' => 'http://img.muyaocn.com/logo-20200103.png'
            ];
            // $params = $request->post();
            // if(empty($params)){
            //     return R('300','参数解析异常');
            // }
            $getPosterWhere = $this->poster_model->getListWhere(['status'=>1,'type'=>4]); // 4:logo
            $getPosterOrder = $this->poster_model->getListOrderBy(['order_by_field'=>'id','order_by_type'=>'DESC']);
            $getPosterInfo = $this->poster_model->getOne($getPosterWhere,$getPosterOrder);
            if(empty($getPosterInfo)){
                return R('200','查询成功',$res);
            }
            return R('200','查询成功',$getPosterInfo);
        }catch (\Exception $e){
            return R('500',$e->getMessage());
        }
    }
}
