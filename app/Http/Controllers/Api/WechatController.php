<?php
namespace App\Http\Controllers\Api;

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
    }

    public function auth(Request $request)
    {
        try{
            if($request->post('user_info')){
                $user_info = jsonDecode($request->post('user_info'));
            }else{
                return R('300','参数解析异常');
            }
            $we_response = http_request(
                "https://api.weixin.qq.com/sns/jscode2session?appid="
                . config('app.wechat_appid')
                . "&secret=" . config('app.wechat_secret')
                . "&js_code=" . $user_info['code']
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

            // 获取地区code
            // $region_res = $this->region_model->getOne(['region'=>['like','上海']]);


            $save_user_data = [
                'user_name' => $user_info['userInfo']['nickName'],
                'user_gender' => $user_info['userInfo']['gender'],
                'address'=>'',
                'status' => 1,
            ];
            $save_user_res = $this->user_model->create($save_user_data);

            if(!$save_user_res){
                DB::rollBack();
                return R('0');
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

            $save_user_extension_res = $this->user_extension_model->create($save_user_extension_data);
            if (!$save_user_extension_res) {
                DB::rollBack();
                return R('0');
            }

            if($save_user_res && $save_user_extension_res){
                DB::commit();
                return R('200');
            }



        }catch (\Exception $e){
            Log::info('微信登录异常,异常信息:'.$e->getMessage());
            return R('500',$e->getMessage());
        }

    }
}
