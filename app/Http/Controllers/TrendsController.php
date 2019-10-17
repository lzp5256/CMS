<?php
namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trends\ArticleModel;

class TrendsController
{
    public function __construct(){}

    public function trendsList(Request $request)
    {
        try{
            if($request->isMethod('post')) {
                $page = $request->post('page', 0);

                $param = [
                    'page' => $page-1,
                    'num' => $request->post('limit', 0),
                ];

                $article_model = new ArticleModel();
                $where = $article_model->getListWhere(['state' => 1]);
                $limit = $article_model->getListLimit($param);
                $count = $article_model->getListCount($where);
                $article_list = $article_model->getList($where, 'id desc', '*', $limit);

                return R('0', $article_list, $count);
            }
            return view('Trends.list');
        }catch (\Exception $e){
            var_dump($e);die;
        }
    }
}

