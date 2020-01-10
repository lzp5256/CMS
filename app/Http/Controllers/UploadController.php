<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class UploadController
{
    public function upload(Request $request)
    {
        try{
            if ($request->isMethod('post')){
                $file = $_FILES['file'];
                $params['list'] = $request->post();
                $token=$this->getToken();
                $uploadManager=new UploadManager();
                list($ret, $err) = $uploadManager->putFile($token, 'G'.date('YmdHHiiss').rand(1000,9999), $file['tmp_name']);
                if ($err !== null) {
                    return R('200001');
                } else {
                    return R('200','上传成功',$ret);
                }
            }
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }

    /**
     * 生成上传凭证
     * @return string
     */
    private function getToken(){
        $accessKey=config('filesystems.qiniu.access_key');
        $secretKey=config('filesystems.qiniu.secret_key');
        $auth=new Auth($accessKey, $secretKey);
        $bucket=config('filesystems.qiniu.bucket');//上传空间名称
        //设置put policy的其他参数
        //$opts=['callbackUrl'=>'http://www.callback.com/','callbackBody'=>'name=$(fname)&hash=$(etag)','returnUrl'=>"http://www.baidu.com"];
        return $auth->uploadToken($bucket);//生成token
    }

    /**
     * 富文本图片上传
     */
    public function e_upload(Request $request)
    {
        try{
            if ($request->isMethod('post')){
                $file = $_FILES['file'];
                $params['list'] = $request->post();
                $token=$this->getToken();
                $uploadManager=new UploadManager();
                list($ret, $err) = $uploadManager->putFile($token, 'G'.date('YmdHHiiss').rand(1000,9999), $file['tmp_name']);
                if ($err !== null) {
                    return R('200001');
                } else {
                    $ret['src'] = 'http://img.muyaocn.com/'.$ret['key'];
                    return R('0','上传成功',$ret);
                }
            }
        }catch (\Exception $e){
            return R('400','错误信息:'.$e->getMessage());
        }
    }
}
