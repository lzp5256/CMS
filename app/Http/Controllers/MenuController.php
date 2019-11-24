<?php
namespace app\Http\Controllers;


use App\Models\System\SystemMenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController
{
    public function __construct(){}

    protected $data = [];
    /**
     * 获取首页页面菜单列表
     * @return false|string
     */
    public function index()
    {
        try{
            $menu_model = new SystemMenuModel();

            $where = $menu_model->getListWhere(['status' => 1]);
            $count = $menu_model->getListCount($where);
            $list = $menu_model->getList($where, 'id desc', '*');

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

    /**
     * 菜单列表展示
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function lists(Request $request)
    {
        try{
            if($request->isMethod('post')) {
                $search = [
                    'title'  => $request->post('title',''),
                    'status' => $request->post('status',''),
                ];

                $menu_model = new SystemMenuModel();

                $where = $menu_model->getListWhere(['status' => 1]);
                $count = $menu_model->getListCount($where);
                $limit = $menu_model->getListLimit(['page'=>$request->post('page')-1,'num'=>$request->post('limit')]);
                $list = $menu_model->getList($where, 'id desc', '*',$limit);

                $status_ops = $menu_model->has('status',100);

                foreach ($list as $k => $v) {
                    $list[$k]['status_str'] =$status_ops[$v['status']];
                    $list[$k]['href'] = empty($v['href']) ? '未配置' : $v['href'];
                }
                return R('0','',$list, $count);
            }

            return View('Menu.list');
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try{
            $menu_model = new SystemMenuModel();
            if($request->isMethod('post')){
                $params = $request->post()['params'];
                if(empty($params['title'])){
                   return R('100004');
                }
                $this->data['title'] = trim($params['title']);
                if($params['parent'] == '' || !isset($params['parent'])){
                    return R('100005');
                }
                $this->data['parent'] = intval($params['parent']);
                if(empty($params['icon'])){
                    return R('100006');
                }
                $this->data['icon'] = trim($params['icon']);
                if(empty($params['target'])){
                    return R('100007');
                }
                $this->data['target'] = trim($params['target']);
                if(empty($params['href'])){
                    return R('100008');
                }
                $this->data['href'] = trim($params['href']);
                $this->data['status'] = 0;
                if(isset($params['status']) && $params['status'] == 1){
                    $this->data['status'] = intval($params['status']);
                }
                $create = $menu_model->create($this->data);
                if($create){
                    return R('200','添加成功'.$create);
                }
                return R('0');
            }
            $where = $menu_model->getListWhere(['status' => 1]); // 一级菜单
            $parent = $menu_model->getList($where, 'id desc', '*');
            return View('Menu.create',compact('parent'));
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }


    public function del(Request $request)
    {
        try{
            if(!$request->isMethod('POST')){
                return R('410');
            }
            $post = $request->post()['params'];
            $menu_id_arr = array_column($post,'id');

            $err_list = [];
            $system_model = new SystemMenuModel();
            foreach ($menu_id_arr as $k => $v) {
                $res = $system_model->del($v,['status'=>0]);
                if(!$res){
                    $err_list[$v] = '删除失败';
                }
            }
            if(!empty($err_list)){
                return R('200','删除失败信息:'.json_encode($err_list,true));
            }

            return R('200','删除成功!');

        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }
}