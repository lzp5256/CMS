<?php

namespace App\Models\System;


use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SystemImageModel extends BaseModel
{
    protected $table = 'm_system_image';

    public function has($filed = '', $val_all = '100')
    {
        $ops = [];

        if ($filed == 'status') {
            $ops = ['1' => '有效', '0' => '无效'];
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
        if (isset($param['id']) && !empty($param['id'])) {
            $where .= 'id = "' . intval($param['id']) . '" and ';
        }
        if (isset($param['goods_id']) && !empty($param['goods_id'])) {
            $where .= 'goods_id = "' . intval($param['goods_id']) . '" and ';
        }
        if (isset($param['id_arr']) && !empty($param['id_arr']) ) {
            $where .= 'goods_id IN ('.$param['id_arr'].') and ';
        }
        if (isset($param['type_arr']) && !empty($param['type_arr'])) {
            $where .= 'type IN ('.$param['type_arr'].') and ';
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

    /**
     * 删除记录
     */
    public function del($where,$data)
    {
        $db = DB::table($this->table);
        $res = $db->where('id','=',$where)->update($data);
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
    protected function getOrderListFiled($param)
    {
        $field = '*';
        //field
        if (isset($param['field_str']) && $param['field_str']) {
            $field = trim($param['field_str']);
        }
        return $field;
    }




}
