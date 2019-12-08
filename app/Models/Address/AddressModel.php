<?php
namespace App\Models\Address;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressModel extends BaseModel
{
    protected $table = 'm_user_address';

    public function getList($where=false,$order=false,$field="*",$limit=false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataList($db,$where,$order,$field,$limit);
        return $data;
    }

    public function getOne($where = false,$order = false,$field='*'){
        $db = DB::table($this->table);
        $data = $this->findData($db,$where,$order,$field);
        return $data;
    }

    public function getListCount($where=false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataCount($db,$where);
        return $data;
    }

    public function getListWhere($param)
    {
        $where = '';
        if(isset($param['status']) && in_array($param['status'],[0,1])){
            $where .= 'status ="' . intval($param['status']). '" and ';
        }
        if (isset($param['user_id']) && !empty($param['user_id'])){
            $where .= 'user_id ="' .trim($param['user_id']) . '" and ';
        }
        if (isset($param['id']) && !empty($param['id'])){
            $where .= 'id ="' .intval($param['id']). '" and ';
        }
        if(strlen($where) > 0){
            $where = substr($where,0,strlen($where)-4);
        }
        return $where;
    }
    /*
     * @Content : 获取limit
     * @Param   : $param
     */
    public function getListLimit($param)
    {
        $limit = [];
        //limit
        if( isset($param['page']) && is_numeric($param['page']) && isset($param['num']) && is_numeric($param['num']) ){
            $limit = ['page' => trim($param['page']),'length' => trim($param['num'])];
        }
        Log::info('limit:['.$param['page'].','.$param['num'].']');
        return $limit;
    }
    /*
     * @Content : 获取order_by
     * @Param   : $param
     */
    public function getListOrderBy($param)
    {
        $order = [];
        //order_by
        if( isset($param['order_by_filed']) && $param['order_by_filed'] && isset($param['order_by_type']) && $param['order_by_type'] ){
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
     */
    public function getListFiled($param)
    {
        $field = '*';
        //field
        if( isset($param['field_str']) && $param['field_str'] ){
            $field = trim($param['field_str']);
        }
        return $field;
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
     * 更新记录
     */
    public function updateById($id, $data)
    {
        return DB::table($this->table)->where('id','=',$id)->update($data);
    }
}
