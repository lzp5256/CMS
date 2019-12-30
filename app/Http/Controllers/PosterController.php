<?php
namespace App\Http\Controllers;

use App\Models\Poster\PosterModel;
use App\Models\System\SystemMenuModel;
use Illuminate\Http\Request;

class PosterController
{
    public function __construct(){}

    /**
     * 海报列表
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function poster_list(Request $request)
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

            return View('Poster.posterlist');
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 创建海报
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function poster_create(Request $request)
    {
        try{
            $time = date('Y-m-d H:i:s');
            $poster_model = new PosterModel();
            if($request->isMethod('post')){
                $params = $request->post('params');
                if(empty($params['poster_name'])){
                    return R('100040');
                }
                if(empty($params['poster_src'])){
                    return R('100041');
                }
                if(empty($params['upload_file'])){
                    return R('100042');
                }
                if(empty($params['poster_type'])){
                    return R('100043');
                }
                if(empty($params['status'])){
                    return R('100022');
                }
                $data = [
                    'src'  => trim($params['poster_src']),
                    'type' => intval($params['poster_type']),
                    'remark' => trim($params['poster_name']),
                    'status' => intval($params['status']),
                    'create_time' => $time,
                ];
                $create = $poster_model->create($data);
                if($create){
                    return R('200','添加成功'.$create);
                }
                return R('0');
            }
            return View('Poster.postercreate');
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }
}