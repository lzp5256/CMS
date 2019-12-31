<?php
namespace App\Http\Controllers;

use App\Models\Goods\GoodsBrandModel;
use App\Models\Goods\GoodsModel;
use App\Models\Goods\GoodsTypeModel;
use App\Models\System\SystemImageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GoodsController
{
    public function __construct(){
        $this->goods_model = new GoodsModel();
        $this->goods_type_model = new GoodsTypeModel();
        $this->goods_brand_model = new GoodsBrandModel();
        $this->system_image_model = new SystemImageModel();
    }

    // 状态列表
    protected $STATUS_LIST = [
        'STATUS_SUCCESS' => 1,
        'STATUS_ERROR'   => 0,
    ];

    // 积分兑换开启状态列表
    protected $REDEEM_LIST = [
        'OFF' => 0,
        'ON'  => 1,
    ];

    protected $params_data = [];

    /**
     * 商品列表
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function lists(Request $request)
    {
        try{
            if($request->isMethod('post')) {

                $where = $this->goods_model->getListWhere(['status' => 1]);
                $count = $this->goods_model->getListCount($where);
                $list = $this->goods_model->getList($where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*');

                $status_ops = $this->goods_model->has('status',100);
                $redeem_ops = $this->goods_model->has('goods_redeem',100);

                foreach ($list as $k => $v) {
                    $list[$k]['status_str'] =$status_ops[$v['status']];
                    $list[$k]['redeem_str'] =$redeem_ops[$v['goods_redeem']];
                }
                return R('0','',$list, $count);
            }

            return View('Goods.goodslist');
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 商品管理-添加商品
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|View|string
     */
    public function goods_create(Request $request)
    {
        try{
            if($request->isMethod('POST')){
                $params = $request->post()['params'];
                if(empty($params['goods_name'])){
                    return R('100016');
                }
                $this->params_data['goods_name'] = trim($params['goods_name']);

                if(empty($params['goods_original_price']) || $params['goods_original_price'] <= 0){
                    return R('100017');
                }
                $this->params_data['goods_original_price'] = bcmul($params['goods_original_price'],100);

                if(empty($params['goods_price']) || $params['goods_price'] <= 0){
                    return R('100018');
                }
                $this->params_data['goods_price'] = bcmul($params['goods_price'],100);

                if(empty($params['goods_vip_price']) || $params['goods_vip_price'] <=0){
                    return R('100019');
                }
                $this->params_data['goods_vip_price'] = bcmul($params['goods_vip_price'],100);

                if(empty($params['goods_stock']) || $params['goods_stock'] <=0){
                    return R('100020');
                }
                $this->params_data['goods_stock'] = intval($params['goods_stock']);

                if(!in_array($params['goods_redeem'],[1,0])){
                    return R('100021');
                }
                $this->params_data['goods_redeem'] = intval($params['goods_redeem']);

                if(!in_array($params['status'],[1,0])){
                    return R('100022');
                }
                $this->params_data['status'] = intval($params['status']);

                if(empty($params['upload_master_file'])){
                    return R('100023');
                }

                if(empty($params['upload_describe_file'])){
                    return R('100024');
                }

                $params['upload_master_file'] = explode(',',$params['upload_master_file']);
                foreach ($params['upload_master_file'] as $k => $v){
                    if(empty($v)){
                        unset($params['upload_master_file'][$k]);
                    }else{
                        $upload_master_file[] = $v;
                    }
                }
                // 开启事务
                DB::beginTransaction();

                $create_goods_res = $this->goods_model->create($this->params_data);
                if(!$create_goods_res){
                    DB::rollBack();
                    return R('0');
                }

                $create_system_master_data = [
                    'target_id' => $create_goods_res,
                    'type' => 1,
                    'src'  => json_encode($upload_master_file),
                    'status' => 1,
                ];
                $create_goods_master_system = $this->system_image_model->create($create_system_master_data);
                if(!$create_goods_master_system){
                    DB::rollBack();
                    return R('0','商品主图保存失败');
                }

                $create_system_describe_data = [
                    'target_id' => $create_goods_res,
                    'type' => 2,



                    'src'  => $params['upload_describe_file'],
                    'status' => 1,
                ];
                $create_goods_describe_system = $this->system_image_model->create($create_system_describe_data);
                if(!$create_goods_describe_system){
                    DB::rollBack();
                    return R('0','商品描述保存失败');
                }

                if($create_goods_res && $create_goods_master_system && $create_goods_describe_system){
                    DB::commit();
                    return R('200');
                }
            }
            return View('Goods.goodscreate');
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 创建新商品
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function goods_type_create(Request $request)
    {
        try{
            if($request->method() == 'POST'){
                $params = $request->all();
                //var_dump($params);
                if(empty($params['params']['type_name'])){
                    return R('100010');
                }
                $this->params_data['type_name'] = (string)$params['params']['type_name'];

                if(empty($params['params']['type_code'])){
                    return R('100011');
                }
                $this->params_data['type_code'] = (string)$params['params']['type_code'];

                if(empty($params['params']['parent'])){
                    return R('100012');
                }
                $this->params_data['parent'] = (string)$params['params']['parent'];

                if(empty($params['params']['status']) || !in_array($params['params']['status'],$this->STATUS_LIST)){
                    return R('100013');
                }
                $this->params_data['status'] = (string)$params['params']['status'];

                if(isset($params['params']['describe'])){
                    $this->params_data['describe'] = (string)$params['params']['describe'];
                }else{
                    $this->params_data['describe'] = '';
                }
                $create_goods_type_data = [
                    'parent' => $this->params_data['parent'],
                    'type_name' => $this->params_data['type_name'],
                    'type_code' => $this->params_data['type_code'],
                    'type_describe' => $this->params_data['describe'],
                    'status' => 1,
                ];
                $create_goods_type_res = $this->goods_type_model->create($create_goods_type_data);
                if(!$create_goods_type_res){
                    return R('0');
                }
                return R('200');
            }
            $parent[] = [
                'id' => 1,
                'type_name' => '一级分类'
            ];
            $list_condation = $this->goods_type_model->getListWhere(['status'=>1]);
            $goods_type_list = $this->goods_type_model->getList($list_condation,'id asc');
            if(!empty($goods_type_list)){
                $parent = $goods_type_list;
            }
            return View('Goods.typecreate',compact('parent'));
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 商品分类列表
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function goods_type_list(Request $request)
    {
        try{
            if($request->isMethod('post')) {
                $where = $this->goods_type_model->getListWhere(['status' => 1]);
                $count = $this->goods_type_model->getListCount($where);
                $list = $this->goods_type_model->getList($where, 'id desc', '*');

                $status_ops = $this->goods_type_model->has('status',100);

                foreach ($list as $k => $v) {
                    $list[$k]['status_str'] =$status_ops[$v['status']];
//                    $list[$k]['href'] = empty($v['href']) ? '未配置' : $v['href'];
                }
                return R('0','',$list, $count);
            }
            return View('Goods.typelist');
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 商品管理-品牌管理-列表
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|View|string
     */
    public function goods_brand_list(Request $request)
    {
        try{
            if ($request->isMethod('POST')){
                $where = $this->goods_brand_model->getListWhere(['status' => 1]);
                $count = $this->goods_brand_model->getListCount($where);
                $list = $this->goods_brand_model->getList($where, 'id desc', '*');
                $status_ops = $this->goods_brand_model->has('status',100);
                foreach ($list as $k => $v) {
                    $list[$k]['status_str'] =$status_ops[$v['status']];
                }
                return R('0','',$list, $count);
            }
            return View('Goods.brandlist');
        }catch (\Exception $e){

        }
    }

    /**
     * 商品管理-品牌管理-新增
     * @param Request $request
     * @return false|\Illuminate\Contracts\View\Factory|View|string
     */
    public function goods_brand_create(Request $request)
    {
        try{
            if ($request->isMethod('POST')){
                $params = $request->post()['params'];
                if (empty($params['brand_name']) || !isset($params['brand_name'])){
                    return R('100014');
                }
                $this->params_data['brand_name'] = (string)trim($params['brand_name']);

                if (empty($params['brand_code']) || !isset($params['brand_code'])){
                    return R('10015');
                }
                $this->params_data['brand_code'] = (string)trim($params['brand_code']);

                if (!in_array($params['status'],$this->STATUS_LIST)){
                    return R('100009');
                }
                $this->params_data['status'] = (int)$params['status'];

                $res = $this->goods_brand_model->create($this->params_data);

                if(!$res){
                    return R('0');
                }
                return R('200');
            }

            return View('Goods.brandcreate');
        }catch (\Exception $e){
            return R('410',$e->getMessage());
        }
    }
}
