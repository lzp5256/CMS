<?php
namespace App\Http\Controllers\Api;

use App\Models\Poster\PosterModel;
use App\Models\Goods\GoodsModel;

class IndexController
{
    public function __construct(){
        $this->poster_model = new PosterModel();
        $this->goods_model = new GoodsModel();
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
        $res = $this->goods_model->getList($condition);
        $res = empty($res) ? [] : $res;
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


}