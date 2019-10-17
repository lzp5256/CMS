<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    /*
     * @Param   : [
     *				'db' => $db_connection,
     *				'where' => where条件sql 例如:where id=1 and name = "jacky",
     *				'limit' => [
     *					'start' => 开始
     *					'length' => 条数
     *				]
     *				'order' => [
     *					'field' => 字段
     *					'type' => 'desc/asc'
     *              ]
     *				'field' => 查询字段部分sql 例如: id,name,pwd 默认为&
     *				]
     * Return:[]
     * Time:2019.08.27
     */
    public function getDataList($db,$where,$order,$field,$limit)
    {
        if($where){
            $db->whereRaw($where);
        }
        if(!empty($limit) && isset($limit['page']) && isset($limit['length'])){
            Log::info('getDataList:limit:['.$limit['page'].','.$limit['length'].']');
            $num = $limit['length'];
            $page = intval($limit['page']) == 0 ? 0 : intval($limit['page']);
            $start = $page * $num;
            Log::info('start:'.$start."(".$page.'):num:'.$num);
            $db->skip($start)->take($num);
        }
        if($order && isset($order['order_by_filed']) && isset($order['order_by_type'])){
            $db->orderBy($order['order_by_filed'],$order['order_by_type']);
        }elseif(is_array($order) && !empty($order)){
            foreach($order as $o){
                if(isset($o['order_by_filed']) && isset($o['order_by_type'])){
                    $db->orderBy($o['order_by_filed'],$o['order_by_filed']);
                }
            }
        }

        if(!empty($field)){
            $db->select($field);
        }
        $data = $db->get();
        if(empty($data)){
            return [];
        }
        return $data->toArray();
    }

    /*
	 * Content : 查询单条记录
	 */
    public function findData($db,$where,$order,$field)
    {
        if($where){
            $db->whereRaw($where);
        }
        if($order && isset($order['field']) && isset($order['type'])){
            $db->orderBy($order['field'],$order['type']);
        }
        if($field){
            $db->select($field);
        }
        $data = $db->first();

        return $data;
    }
    /*
     * Desc : 查询总条数
     * Param   : [
     *				'bd' => $db_connection,
     *				'where' => where_string,
     *			  ]
     * Return  : []
     */
    public function getDataCount($db,$where)
    {
        if($where){
            $db->whereRaw($where);
        }
        $data = $db->count();

        return $data;
    }
}
