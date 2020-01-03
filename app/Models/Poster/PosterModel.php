<?php
namespace App\Models\Poster;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PosterModel extends BaseModel
{
    protected $table ='m_poster';

    protected $type_list = [1,2,3,4]; // 类型 1：首页轮播banner(大图)  2：首页小海报 3:精品推荐banner 4:logo

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

    // 获取列表
    public function getList($where = false, $order = false, $field = "*", $limit = false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataList($db, $where, $order, $field, $limit);
        return $data;
    }

    // 获取单条记录
    public function getOne($where = false,$order = false,$field='*'){
        $db = DB::table($this->table);
        $data = $this->findData($db,$where,$order,$field);
        return $data;
    }

    // 获取查询条数
    public function getListCount($where = false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataCount($db, $where);
        return $data;
    }

    // 获取查询条件
    public function getListWhere($param)
    {
        $where = '';
        if (isset($param['status']) && in_array($param['status'], [0, 1])) {
            $where .= 'status ="' . intval($param['status']) . '" and ';
        }
        if (isset($param['id']) && !empty($param['id'])) {
            $where .= 'id = "' . intval($param['id']) . '" and ';
        }
        if (isset($param['type']) && !empty($param['type']) && in_array($param['type'],$this->type_list)){
            $where .= 'type = "' .intval($param['type']) . '" and ';
        }
        if (strlen($where) > 0) {
            $where = substr($where, 0, strlen($where) - 4);
        }
        return $where;
    }

    // 获取limit
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

    // 创建新记录
    public function create($data)
    {
        if (!isset($data['create_time'])) {
            $data['create_time'] = date('Y-m-d H:i:s');
        }
        $db = DB::table($this->table);
        $res = $db->insertGetId($data);
        return $res;
    }

    // 删除记录
    public function del($where,$data)
    {
        $db = DB::table($this->table);
        $res = $db->where('id','=',$where)->update($data);
        return $res;
    }

    // 获取order_by
     public function getListOrderBy($param)
    {
        $order = [];
        //order_by
        if (isset($param['order_by_field']) && $param['order_by_field'] && isset($param['order_by_type']) && $param['order_by_type']) {
            $order = [
                'field' => trim($param['order_by_field']),
                'type' => trim($param['order_by_type']),
            ];
        }
        return $order;
    }

    // 获取field
    protected function getOrderListFiled($param)
    {
        $field = '*';
        //field
        if (isset($param['field_str']) && $param['field_str']) {
            $field = trim($param['field_str']);
        }
        return $field;
    }

    // 更新记录
    public function updateById($id,$data)
    {
        return DB::table($this->table)
            ->where('id','=',$id)
            ->where('status','=',1)
            ->update($data);
    }
}
