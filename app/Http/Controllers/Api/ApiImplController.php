<?php
namespace App\Http\Controllers\Api;

class ApiImplController
{
    protected $call_back_func = '';   // 回调方法
    protected $params = array();      // 参数

    public function Get($method,$param,&$res)
    {
        try{
            $params_log = array('params'=>$param);
            $this->params = jsonDecode($param);

        }catch (\Exception $e){
            return R('500',$e->getMessage());
        }
    }
}