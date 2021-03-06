<?php

namespace App\Models\Goods;


use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoodsModel extends BaseModel
{
    protected $table = 'm_goods';

    public function has($filed = '', $val_all = '100')
    {
        $ops = [];

        if ($filed == 'status') {
            $ops = ['1' => '有效', '0' => '无效'];
        }

        if ($filed == 'goods_redeem') {
            $ops = ['1' => '开启', '0' => '关闭'];
        }

        if ($filed == 'reveal_status') {
            $ops = ['1' => '上架', '0' => '下架'];
        }

        if ($filed == 'advance_sale') {
            $ops = ['1' => '开启', '0' => '关闭'];
        }

        if ($val_all == '100') {
            return ['100' => '全部'] + $ops;
        }

        if ($val_all == '0') {
            return $ops;
        }

        if (isset($ops[$val_all])) {
            return $ops[$val_all];
        }

        return [];
    }

    public function getList($where = false, $order = false, $field = "*", $limit = false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataList($db, $where, $order, $field, $limit);
        return $data;
    }

    public function getOne($where = false , $order = false, $field = '*')
    {
        $db = DB::table($this->table);
        $data = $this->findData($db,$where,$order,$field);
        return $data;
    }

    public function getListCount($where = false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataCount($db, $where);
        return $data;
    }

    public function getListWhere($param)
    {
        $where = '';
        if (isset($param['status']) && in_array($param['status'], [0, 1])) {
            $where .= 'status ="' . intval($param['status']) . '" and ';
        }
        if (isset($param['parent']) && !empty($param['status'])) {
            $where .= 'parent ="' . intval($param['parent']) . '" and ';
        }
        if (isset($param['id']) && !empty($param['id']) && $param['id'] >0){
            $where .= 'id ="' .intval($param['id']) . '" and ';
        }
        if (isset($param['goods_advance_sale']) && !empty($param['goods_advance_sale'])){
            $where .= 'goods_advance_sale ="' .intval($param['goods_advance_sale']). '" and ';
        }
        if (isset($param['goods_redeem']) && !empty($param['goods_redeem'])){
            $where .= 'goods_redeem ="' .intval($param['goods_redeem']). '" and ';
        }
        if (isset($param['reveal_status']) && in_array($param['reveal_status'], [0, 1])) {
            $where .= 'reveal_status ="' . intval($param['reveal_status']) . '" and ';
        }
        if (isset($param['goods_new_status']) && in_array($param['goods_new_status'], [0, 1])) {
            $where .= 'goods_new_status ="' . intval($param['goods_new_status']) . '" and ';
        }
        if (isset($param['goods_advance_sale']) && in_array($param['goods_advance_sale'], [0, 1])) {
            $where .= 'goods_advance_sale ="' . intval($param['goods_advance_sale']) . '" and ';
        }
        if (strlen($where) > 0) {
            $where = substr($where, 0, strlen($where) - 4);
        }
        return $where;
    }

    /*
     * @Content : 获取limit
     * @Param   : $param
     * @Return  : [
     *				'limit' => [
     *								'page' => 开始
     *								'length' => 条数
     *							]
     *				]
     */
    public function getListLimit($param)
    {
        $limit = [];
        //limit
        if (isset($param['page']) && is_numeric($param['page']) && isset($param['num']) && is_numeric($param['num'])) {
            $limit = ['page' => trim($param['page']), 'length' => trim($param['num'])];
        }
        Log::info('limit:[' . $param['page'] . ',' . $param['num'] . ']');
        return $limit;
    }

    /**
     * 创建新记录
     */
    public function create($data)
    {
        if (!isset($data['create_time'])) {
            $data['create_time'] = date('Y-m-d H:i:s');
        }
        $db = DB::table($this->table);
        $res = $db->insertGetId($data);
        return $res;
    }

    /*
     * @Content : 获取order_by
     * @Param   : $param
     * @Return  : [
     *				'order' => [
     *								'field' => 字段
     *								'type' => 'desc/asc'
     *							]
     *				]
     */
    protected function getListOrderBy($param)
    {
        $order = [];
        //order_by
        if (isset($param['order_by_filed']) && $param['order_by_filed'] && isset($param['order_by_type']) && $param['order_by_type']) {
            $order = [
                'field' => trim($param['order_by_field']),
                'type' => trim($param['order_by_type']),
            ];
        }
        return $order;
    }

    /*
     * @Content : 获取field
     * @Param   : $param
     * @Return  : [
     *				'field' => 查询字段部分sql 例如: id,name,pwd 默认为*
     *				]
     */
    protected function getListFiled($param)
    {
        $field = '*';
        //field
        if (isset($param['field_str']) && $param['field_str']) {
            $field = trim($param['field_str']);
        }
        return $field;
    }

        /**
     * 更新记录
     */
    public function updateById($id, $data)
    {
        return DB::table($this->table)->where('id','=',$id)->update($data);
    }

}
