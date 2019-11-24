<?php
namespace app\Http\Controllers;

use App\Models\System\SystemMenuModel;

class HomeController
{
    public function __construct()
    {
        $this->SystemMenuModel = new SystemMenuModel();
    }

    public function index()
    {
        try{
            $where = $this->SystemMenuModel->getListWhere(['status' => 1]);
            $count = $this->SystemMenuModel->getListCount($where);
            $list = $this->SystemMenuModel->getList($where, ['order_by_filed'=>'sort', 'order_by_type'=>'desc'], '*');
            foreach ($list as $index => $value) {
                $menu_list[$value['id']]['id'] = $value['id'];
                $menu_list[$value['id']]['parent'] = $value['parent'];
                $menu_list[$value['id']]['title'] = $value['title'];
                $menu_list[$value['id']]['icon'] = $value['icon'];
                $menu_list[$value['id']]['target'] = $value['target'];
                $menu_list[$value['id']]['href'] = $value['href'];
            }
            $menu = generateTree($menu_list);
            return view('Home.index',compact('menu'));
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
        return view('Home.index',compact('parent'));
    }

    public function welcome()
    {
        return view('Home.welcome');
    }
}