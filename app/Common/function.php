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
    function R($code, $msg='',$data = [],$count = 0){
        return json_encode([
            'code'=>$code,
            'msg'=> !empty($msg) ? $msg : MG($code),
            'data'=>$data,
            'count'=>$count
        ],JSON_UNESCAPED_UNICODE);
    }
}

/**
 * 获取菜单
 * @param $items
 * @return array
 */
if(!function_exists('generateTree'))
{
    function generateTree($items)
    {
        $tree = $menu = array();
        foreach($items as $item){
            if(isset($items[$item['parent']])){
                $items['title'] = $item['title'];
                $items['icon']  = $item['icon'];
                $items[$item['parent']]['child'][] = &$items[$item['id']];
            }else{
                $tree[] = &$items[$item['id']];
            }
        }
        foreach ($tree as $k => $v){
            $menu[$k] = $v;
        }
        return $menu;
    }
}

if(!function_exists('jsonDecode'))
{
    function jsonDecode($data)
    {
        return json_decode($data,true);
    }
}

if(!function_exists('http_request'))
{
    function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}

