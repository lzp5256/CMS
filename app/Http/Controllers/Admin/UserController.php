<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $param = $request->all();

        if(empty($param['userName'])){
            return R('100001');
        }
        if(empty($param['userPwd'])){
            return R('100002');
        }

        $db = DB::select('select * from personnel where user_name = ? and status = ? and user_pwd = ? ',[
            $param['userName'],1,$param['userPwd']]
        );
       // Log::debug('DB::UserLogin【name:'.$param['userName'].'pwd:'.$param['passWord']);
        if(empty($db)){
            return R('100003');
        }

        return R('1');
    }

    public function UserList(Request $request)
    {
        $param = $request->all();
        if($request->isMethod('post')){
            $userModel = new UserModel();
            $limit = $userModel->getListLimit(['page'=>$param['start'],'num'=>$param['length']]);
            $where = $userModel->getListWhere(['status'=>1]);
            $data['data'] = $userModel->getUserList($where,['order_by_filed'=>'id','order_by_type'=>'desc'],'*',$limit);
            $data['recordsTotal'] = DB::table('user')->where('status',1)->count();
            $data['recordsFiltered'] = $data['recordsTotal'];
            $data['draw'] = $param['draw'];

            return json_encode($data);
        }
        return view('Admin.User.list');
    }
}