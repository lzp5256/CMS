<?php

namespace App\Models\User;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserModel extends BaseModel
{
    protected $table ='user';

    public function getUserList($where=false,$order=false,$field="*",$limit=false)
    {
        $db = DB::table('user');
        $data = $this->getDataList($db,$where,$order,$field,$limit);
        return $data;
    }

    public function getListWhere($param)
    {
        $where = '';
        if(isset($param['status']) && in_array($param['status'],[0,1])){
            $where .= 'status ="' . intval($param['status']). '" and ';
        }
        if(strlen($where) > 0){
            $where = substr($where,0,strlen($where)-4);
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
        if( isset($param['page']) && is_numeric($param['page']) && isset($param['num']) && is_numeric($param['num']) ){
            $limit = ['page' => trim($param['page']),'length' => trim($param['num'])];
        }
        Log::info('limit:['.$param['page'].','.$param['num'].']');
        return $limit;
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
     * @Return  : [
     *				'field' => 查询字段部分sql 例如: id,name,pwd 默认为*
     *				]
     */
    protected function getOrderListFiled($param)
    {
        $field = '*';
        //field
        if( isset($param['field_str']) && $param['field_str'] ){
            $field = trim($param['field_str']);
        }
        return $field;
    }
}
