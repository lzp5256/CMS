<?php
namespace app\Http\Controllers;

use App\Models\User\UserModel;
use Illuminate\Http\Request;

class UserController
{
    public function lists(Request $request)
    {
        try{
            if($request->isMethod('post')) {
                $page = $request->post('page', 0);

                $param = [
                    'page' => $page-1,
                    'num' => $request->post('limit', 0),
                ];

                $user_model = new UserModel();
                $where = $user_model->getListWhere(['status' => 1]);
                $limit = $user_model->getListLimit($param);
                $count = $user_model->getUserListCount($where);
                $user_list = $user_model->getUserList($where, 'id desc', '*', $limit);

                return R('0', $user_list, $count);
            }
            return view('User.list');
        }catch (\Exception $e){
            var_dump($e);die;
        }
    }
}
