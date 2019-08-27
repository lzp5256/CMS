<?php
// 公共方法


if(!function_exists('test'))
{
    function test(){
        return 'test';
    }
}

if(!function_exists('R'))
{
    function R($code,$data = []){
        return json_encode(['code'=>$code,'msg'=>MG($code),'data'=>$data],JSON_UNESCAPED_UNICODE);
    }
}
