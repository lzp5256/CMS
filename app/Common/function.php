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
    function generateTree($items){
        $type_arr = [
            '0' => 'currency',
            '1' => 'component',
            '2' => 'other',
        ];
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
            $menu['menuInfo'][$type_arr[$k]] = $v;
        }
        return $menu;
    }
}