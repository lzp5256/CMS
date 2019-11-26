<?php
namespace App\Http\Controllers\Api;

use App\Models\Goods\GoodsModel;
use App\Models\System\SystemImageModel;
use Illuminate\Http\Request;

class GoodsController
{
    protected $TYPE_LIST = [
        'G_MASTER'   => 1, //主图
        'G_DESCRIBE' => 2, // 描述
    ];
    public function __construct()
    {
        $this->goods_model = new GoodsModel();
        $this->system_image_model = new SystemImageModel();
    }

    /**
     * API - 获取商品列表
     * @param Request $request
     * @return false|string
     */
    public function get_goods_list(Request $request)
    {
        try{
            $params = $request->post();
            if(empty($params['page']) || $params['page'] <= 0 ){
                return R('100025');
            }
            $params['page'] = $params['page']-1;
            $params['num'] = isset($params['num']) ? $params['num'] : 10;

            $where = $this->goods_model->getListWhere(['status' => 1]);
            $count = $this->goods_model->getListCount($where);
            $limit = $this->goods_model->getListLimit($params);
            $list = $this->goods_model->getList($where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*',$limit);

            $goods_id = array_column($list,'id');

            // 获取图片信息
            $system_image_where = $this->system_image_model->getListWhere(['id_arr'=>implode(',',$goods_id),'type_arr'=>implode(',',[1,2])]);
            $system_image_list =  $this->system_image_model->getList($system_image_where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*',$limit);
            foreach ($system_image_list as $k => $v){
                $image_list[$v['target_id']][$v['type']] = $v['src'];
            }
            foreach ($list as $k => $v) {
                $list[$k]['goods_original_price'] = bcdiv($v['goods_original_price'],100,2);
                $list[$k]['goods_price'] = bcdiv($v['goods_price'],100,2);
                $list[$k]['goods_vip_price'] = bcdiv($v['goods_vip_price'],100,2);
                $list[$k]['image_master'] = isset($image_list[$v['id']]) ? json_decode($image_list[$v['id']][1],true) : '';
                $list[$k]['image_describe'] = isset($image_list[$v['id']]) ? $image_list[$v['id']][2] : '';
                $list[$k]['host_url'] = config('app.host_url').'/';
            }

            return R('200','获取成功',$list,$count);
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }

    }

    /**
     * API - 获取商品详情
     * @param Request $request
     * @return false|string
     */
    public function get_goods_info(Request $request)
    {
        try{
            $params = $request->post();
            if(empty($params['id'])){
                return R('100026');
            }
            $where = $this->goods_model->getListWhere(['status'=>1,'id'=>intval($params['id'])]);
            $info  = $this->goods_model->getOne($where);

            // 获取图片信息
            $system_image_where = $this->system_image_model->getListWhere(['target_id'=>$info['id'],'type_arr'=>implode(',',[1,2])]);
            $system_image_list =  $this->system_image_model->getList($system_image_where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*');

            foreach ($system_image_list as $k => $v){
                $image_list[$v['target_id']][$v['type']] = $v['src'];
            }
            $info['goods_original_price'] = bcdiv($info['goods_original_price'],100,2);
            $info['goods_price'] = bcdiv($info['goods_price'],100,2);
            $info['goods_vip_price'] = bcdiv($info['goods_vip_price'],100,2);
            $info['image_master'] = isset($image_list[$info['id']]) ? json_decode($image_list[$info['id']][1],true) : '';
            $info['image_describe'] = isset($image_list[$info['id']]) ? $image_list[$info['id']][2] : '';
            $info['host_url'] = config('app.host_url').'/';

            return R('200','获取成功',$info);

        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }
}
