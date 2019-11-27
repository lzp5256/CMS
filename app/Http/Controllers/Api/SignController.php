<?php
namespace App\Http\Controllers\Api;

use App\Models\Sign\SignConfigModel;
use Illuminate\Http\Request;

class SignController
{
    public function __construct()
    {
        $this->sign_config_model = new SignConfigModel();
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
}
