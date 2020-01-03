<?php
namespace App\Http\Controllers\Api;

use App\Models\SalesOrder\SalesOrderModel;
use Illuminate\Http\Request;

class OrderController
{
    public function __construct(){
        $this->sales_order_model = new SalesOrderModel();
    }

    /**
     * 获取订单列表
     * @param Request $request
     * @return false|string
     */
    public function get_order_list(Request $request)
    {
        $params = $request->post();
        if(empty($params)){
            return R('300001');
        }
        if(empty($params['page']) || $params['page'] <= 0 ){
            return R('100025');
        }
        $params['page'] = $params['page']-1;
        $params['num'] = isset($params['num']) ? $params['num'] : 5;

        $where = $this->sales_order_model->getListWhere(['status' => 1,'goods_redeem'=>1]);
        $count = $this->sales_order_model->getListCount($where);
        $limit = $this->sales_order_model->getListLimit($params);
        $list = $this->sales_order_model->getList($where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*',$limit);

        return R('200','查询成功',$list,$count);
    }

    /**
     * 创建订单
     * @param Request $request
     * @return false|string
     */
    public function set_create_order(Request $request)
    {
        $params = $request->post();
        $order_sn = getOrderSn();
        return R('200','创建成功');
    }
}
