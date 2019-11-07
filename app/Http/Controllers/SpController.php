<?php
namespace app\Http\Controllers;

use app\Models\Sp\SpModel;

class SpController
{
   public function __construct(){}

   public function lists()
   {
       try{
           $sp_model = new SpModel();

           $where = $sp_model->getListWhere(['status' => 1]);
           $count = $sp_model->getListCount($where);
           $list  = $sp_model->getList($where, 'id desc', '*');
           $menu_list = [];
           foreach ($list as $index => $value) {
               $menu_list[$value['id']]['id'] = $value['id'];
               $menu_list[$value['id']]['parent'] = $value['parent'];
               $menu_list[$value['id']]['title'] = $value['title'];
               $menu_list[$value['id']]['icon'] = $value['icon'];
               $menu_list[$value['id']]['target'] = $value['target'];
               $menu_list[$value['id']]['href'] = $value['href'];
           }
           return R('0','',generateTree($menu_list), $count);

       }catch (\Exception $e){
           return R('400','错误信息:'.$e->getMessage());
       }
   }
}
