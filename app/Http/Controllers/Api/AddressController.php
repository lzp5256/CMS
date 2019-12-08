<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Address\AddressModel;
use Illuminate\Http\Request;

class AddressController extends BaseController
{
    public function __construct()
    {
        $this->address_model = new AddressModel();
    }

    /**
     * 获取地址列表
     * @param Request $request
     * @return false|string
     */
    public function get_address_list(Request $request)
    {
        try{
            $params  = $request->post();
            $headers = $request->header();
            // 验证token
            if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
                return R($verify_token_res['code'],$verify_token_res['msg']);
            }
            $user = $verify_token_res['data'];

            if(empty($params['page']) || $params['page'] <= 0 ){
                return R('100025');
            }
            $params['page'] = $params['page']-1;
            $params['num'] = isset($params['num']) ? $params['num'] : 10;

            $where = $this->address_model->getListWhere(['status' => 1,'user_id'=>$user['id']]);
            $count = $this->address_model->getListCount($where);
            $limit = $this->address_model->getListLimit($params);
            $list = $this->address_model->getList($where, ['order_by_filed'=>'id', 'order_by_type'=>'desc'], '*',$limit);

            return R('200','查询成功',$list,$count);

        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 添加 || 更新用户收货地址
     * @param Request $request
     * @return false|string
     */
    public function set_address_info(Request $request)
    {
       try{
           $params = $request->post();
           $headers = $request->header();

           // 验证token
           if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
               return R($verify_token_res['code'],$verify_token_res['msg']);
           }
           $user = $verify_token_res['data'];
           if(empty($params['real_name'])){
                return R('100035');
           }
           if(empty($params['phone'])){
               return R('100036');
           }
           if(empty($params['address'])){
               return R('100038');
           }
           if(empty($params['detail'])){
               return R('100037');
           }
           $address = $params['address'];
           if(empty($params['id'])){
              $data = [
                  'user_id' => (int)$user['id'],
                  'real_name' => trim($params['real_name']),
                  'phone' => trim($params['phone']),
                  'province' => $address['province'],
                  'city' => $address['city'],
                  'district' => $address['district'],
                  'address' => $params['detail'],
                  'default' => isset($params['is_default']) && $params['is_default'] == 1 ? 1 : 0,
                  'status'  => 1,
                  'create_time' => date('Y-m-d H:i:s')
              ];
              $create_res = $this->address_model->create($data);
              if(!$create_res){
                  return R('0');
              }
              return R('200');
           }else{
               $data = [
                   'real_name' => trim($params['real_name']),
                   'phone' => trim($params['phone']),
                   'province' => $address['province'],
                   'city' => $address['city'],
                   'district' => $address['district'],
                   'address' => $params['detail'],
                   'default' => isset($params['is_default']) && $params['is_default'] == 1 ? 1 : 0,
               ];
               $update_res = $this->address_model->updateById($params['id'],$data);
               if(!$update_res){
                   return R('0');
               }
               return R('200');
           }
       } catch (\Exception $e){
           return R('400','错误信息:'.$e->getMessage());
       }
    }


    public function get_address_default(Request $request)
    {
        try{
            $headers = $request->header();

            // 验证token
            if (($verify_token_res = json_decode($this->token_verify($headers),true)) && $verify_token_res['code'] != '200'){
                return R($verify_token_res['code'],$verify_token_res['msg']);
            }
            $user = $verify_token_res['data'];

            // 获取默认地址
            $where = $this->address_model->getListWhere(['status' => 1 ,'user_id'=>$user['id']]);
            $res = $this->address_model->getOne($where);

            return R('200','查询成功',$res);
        }catch (\Exception $e){
           return R('400','错误信息:'.$e->getMessage());
        }
    }

    public function get_address_detail(Request $request)
    {
        try{
            $id = $request->post('addressId');

            if(!isset($id) || empty($id)){
                return R('100039');
            }
            $where = $this->address_model->getListWhere(['status'=>1,'id'=>$id]);
            $res = $this->address_model->getOne($where);

            return R('200','查询成功',$res);

        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }
}