<?php
namespace App\Http\Controllers\Common;

use App\Models\System\SystemImageModel;

class CommonController
{
    public function __construct()
    {
        $this->system_image_model = new SystemImageModel();
    }

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
            'traget_id' => (int) $target,       // 根据type来区分 | type = 1 为商品id  | type=2为商品id |  type=10为用户id
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
}
