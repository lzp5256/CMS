<?php
namespace app\Models\Sp;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SpModel extends BaseModel
{
    protected $table ='m_sp';

    public function has($filed = '', $val_all = '100')
    {
        $ops = [] ;

        if($filed == 'status'){
            $ops = ['1' => '有效' , '0' => '无效'];
        }

        if($val_all == '100'){
            return ['100'=>'全部'] + $ops;
        }

        if($val_all == '0'){
            return $ops;
        }

        if(isset($ops[$val_all])){
            return $ops[$val_all];
        }

        return [];
    }

    public function getList($where=false,$order=false,$field="*",$limit=false)
    {
        $db = DB::table($this->table);
        $data = $this->getDataList($db,$where,$order,$field,$limit);
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
        if(isset($param['state']) && in_array($param['state'],[0,1])){
            $where .= 'state ="' . intval($param['state']). '" and ';
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