<?php
namespace App\Http\Controllers\Api;

use App\Models\Poster\PosterModel;
use App\Models\Goods\GoodsModel;
use App\Models\System\SystemImageModel;

class IndexController
{
    public function __construct(){
        $this->poster_model = new PosterModel();
        $this->goods_model = new GoodsModel();
        $this->system_image_model = new SystemImageModel();
    }

    /**
     * 获取首页数据 1.banner 
     * @return false|string
     */
    public function index()
    {
        $banners_res = $this->getBanners(); // 获取banner
        $activitys_res = $this->getActivitys();
        $firstList = $this->getFirstList();
        $benefit_res = $this->getBenefits();
        $res = [
            'banner' => $banners_res,
            'activity' => $activitys_res,
            'firstInfo' => '',
            'firstList' => $firstList,
            'salesInfo' => '',
            'benefit' => $benefit_res,
            'logoUrl' => 'http://img.muyaocn.com/logo-20200103.png',
            'couponList' => [],
        ];
        return R('200','查询成功',$res);
    }

    /**
     * 获取首页banner
     * @return array
     */
    protected function getBanners()
    {
        $condition = $this->poster_model->getListWhere(['status'=>1,'type'=>1]);
        $res = $this->poster_model->getList($condition);
        $res = empty($res) ? [] : $res;
        return $res;
    }

    /**
     * 获取活动信息
     * @return array
     */
    protected function getActivitys()
    {
        $condition = $this->poster_model->getListWhere(['status'=>1,'type'=>2]);
        $res = $this->poster_model->getList($condition);
        $res = empty($res) ? [] : $res;
        return $res;
    }

    /**
     * 获取新品列表
     * @return array
     */
    protected function getFirstList()
    {
        $condition = $this->goods_model->getListWhere([
            'status'=>1,
            'reveal_status'=>1,
            'goods_new_status' => 1,
        ]);
        $goods_list = $this->goods_model->getList($condition);
        $res = empty($goods_list) ? [] : $goods_list;
        foreach($res as $k => $v){
            $goods_id_arr[] = $v['id']; 
        }
        $image_list = $this->getGoodsImages('1',$goods_id_arr);

        foreach ($res as $k => $v) {
            $res[$k]['goods_original_price'] = bcdiv($v['goods_original_price'],100,2);
            $res[$k]['goods_price'] = bcdiv($v['goods_price'],100,2);
            $res[$k]['goods_vip_price'] = bcdiv($v['goods_vip_price'],100,2);
            $res[$k]['image_master'] = isset($image_list[$v['id']]) ? config('app.host_url').'/'.json_decode($image_list[$v['id']][1],true)[0] : '';
            //$res[$k]['host_url'] = config('app.host_url').'/';
        }
        return $res;
    }

    /**
     * 获取预售产品列表
     * @return array
     */
    protected function getBenefits()
    {
        $condition = $this->goods_model->getListWhere([
            'status'=>1,
            'goods_advance_sale'=>1,
        ]);
        $res = $this->goods_model->getList($condition);
        $res = empty($res) ? [] : $res;
        return $res;
    }

    protected function getGoodsImages($type,$ids = [])
    {
        // 获取图片信息
        $system_image_where = $this->system_image_model->getListWhere(['id_arr'=>implode(',',$ids),'type'=>$type]);
        $system_image_list =  $this->system_image_model->getList($system_image_where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*');
        foreach ($system_image_list as $k => $v){
            $image_list[$v['target_id']][$v['type']] = $v['src'];
        }
        return $image_list;
    }


}