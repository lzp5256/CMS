<?php
namespace App\Http\Controllers\Common;

use App\Models\Integral\IntegralFlowModel;
use App\Models\Integral\IntegralModel;
use App\Models\System\SystemImageModel;
use App\Models\User\UserModel;

class CommonController
{
    public function __construct()
    {
        $this->system_image_model = new SystemImageModel();
        $this->user_model = new UserModel();
        $this->integral_model = new IntegralModel();
        $this->integral_flow_model = new IntegralFlowModel();
    }

    #================================== 图片相关 =================================#

    /**
     * 公共方法：创建新图片信息，唯一入口
     *
     * @param string $src  图片地址
     * @param int $type    图片类型
     * @param int $target  图片对应功能id
     * @return false|string
     */
    public function CreateImages($src = '',$type = 0 , $target = 0 )
    {
        // 参数验证
        if(empty($src)) return R('0','添加图片失败');
        if($type <= 0 || empty($type) || !isset($type)) return R('0','图片类型标识识别失败');
        if($target <= 0 || empty($target) || !isset($target)) return R('0','图片ID解析失败');

        $create_data = [
            'target_id' => (int) $target,       // 根据type来区分 | type = 1 为商品id  | type=2为商品id |  type=10为用户id
            'type'      => (int) $type,         // 类型 1=商品首图 2=商品详情 3=用户头像
            'src'       => (string) trim($src), // 图片地址,只保存图片名称
            'status'    => (int) 1,             // 状态
            'create_time' => date('Y-m-d H:i:s'), // 创建时间
        ];

        $create_res = $this->system_image_model->create($create_data);
        if(!$create_res) return R('0','图片保存失败');

        return R('200','图片保存成功',$create_res);
    }

    /**
     * 公共方法：更新图片信息，唯一入口
     * @param int $id  图片id
     * @param $data    更新数据
     * @return false|string
     */
    public function UpdateImages($id = 0 , $data)
    {
        if($id<=0)return R('0','数据标识解析失败');
        if(empty($data))return R('0','未获取到更新数据');

        $update_res = $this->system_image_model->updateById($id,$data);

        if(!$update_res) return R('0','图片更新失败');

        return R('200','图片更新成功',$update_res);
    }

    /**
     * 公共方法：获取相关图片信息，唯一入口
     * @param array $id  图片id
     * @param int $type  类型
     * @return false|string
     */
    public function GetImagesById($id = array() , $type = 0)
    {
        if(!is_array($id) || empty($id) ) return R('100028');
        if(empty($type) || !in_array($type,[1,2,3])) return R('100029');

        $where = $this->system_image_model->getListWhere([
            'system_id_arr' => implode(',',$id),
            'type'   => intval($type),
            'status' =>1
        ]);
        $res = $this->system_image_model->getList($where);
        foreach ($res as $k => $v) {
            $response[$v['type']] = $v;
        }
        return R('200','获取成功',$response);
    }

    #================================== 用户相关 =================================#

    /**
     * 公共方法: 获取用户详情，查询用户唯一入口
     * @param $id 用户id
     * @return false|string
     */
    public function GetUserInfo($id)
    {
        if(empty($id) || intval($id) <= 0 || !isset($id)) return R('100027');

        $where = $this->user_model->getListWhere(['id'=>intval($id),'status'=>1]);
        $res = $this->user_model->getOne($where);

        return R('200','用户详情获取成功',$res);
    }

    /**
     * 公共方法: 获取用户积分,唯一入口
     * @param $id 用户Id
     * @return false|string
     */
    public function GetUserIntegral($id)
    {
        if(!isset($id) || empty($id) || $id <= 0) return R('100027');

        $where = $this->integral_model->getListWhere(['user_id'=>$id,'status'=>1]);
        $res = $this->integral_model->getOne($where);

        return R('200','查询成功',$res);
    }

    /**
     * 公共方法:获取用户签到状态
     * @param $id 用户Id
     * @return false|string
     */
    public function GetUserSignInfo($id)
    {
        if(!isset($id) || empty($id) || $id <= 0) return R('100027');

        $where = $this->integral_flow_model->getListWhere(['user_id'=>$id,'status'=>1,'type'=>1,'create_time'=>date('Y-m-d',time())]);
        $res = $this->integral_flow_model->getOne($where);

        return R('200','查询成功',$res);
    }

    /**
     * 公共方法:获取用户签到详情列表
     * @param $id 用户Id
     * @return false|string
     */
    public function GetUserSignList($id)
    {
        if(!isset($id) || empty($id) || $id <= 0) return R('100027');

        $where = $this->integral_flow_model->getListWhere(['user_id'=>$id,'status'=>1,'type'=>1]);
        $count = $this->integral_flow_model->getListCount($where);
        $res   = $this->integral_flow_model->getList($where,['order_by_filed'=>'id','order_by_type'=>'desc']);

        return R('200','查询成功',$res,$count);
    }

    #================================== 积分相关 =================================#

    /**
     * 公共方法:添加积分流水记录
     * @param int $user_id 用户id
     * @param int $type 类型
     * @param int $target_id 类型对应的id
     * @param int $reward  积分
     * @return false|string
     */
    public function SetIntegralFlow($user_id = 0 , $type = 1, $target_id = 0 , $reward = 0)
    {
        if (!isset($user_id) || empty($user_id) || $user_id <= 0) return R('100027');
        if (empty($type) || $type < 1) return R('100031');
        if (empty($target_id) || $target_id <= 0) return R('100032');

        $create_data = [
            'user_id'   => $user_id,
            'type'      => $type,
            'target_id' => $target_id,
            'reward'    => $reward,
            'status'    => 1,
            'create_time' => date('Y-m-d H:i:s'),
        ];
        $create_integral_flow_res = $this->integral_flow_model->create($create_data);
        if (!$create_integral_flow_res){
            return R('0','添加积分流水失败');
        }
        return R('200','添加成功',['id'=>$create_integral_flow_res]);
    }

    public function SetIntegral($user_id = 0 ,$total = 0)
    {
        if (empty($user_id) || $user_id <= 0) return R('100027');

        $get_integral_where = $this->integral_model->getListWhere(['status'=>1,'user_id'=>intval($user_id)]);
        $get_user_integral = $this->integral_model->getOne($get_integral_where);

        // 用户积分账户不存在
        if (empty($get_user_integral)){
            $data['total']   = intval($total);
            $data['status']  = 1;
            $data['user_id'] = intval($user_id);
            $data['create_time'] =date('Y-m-d H:i:s');
            $create_integral_res = $this->integral_model->create($data);
            if(!$create_integral_res){
                return R('0','创建用户积分账户失败');
            }
            return R('200','成功',['id'=>$create_integral_res]);
        }
        // 用户积分账户存在
        $update_integral_res = $this->integral_model->incrementById($get_user_integral['id'],'total',intval($total));

        if(!$update_integral_res){
            return R('0','用户积分账户更新失败');
        }

        return R('200','成功',['id'=>$update_integral_res]);
    }
}
