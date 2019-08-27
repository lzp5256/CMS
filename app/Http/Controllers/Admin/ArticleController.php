<?php
namespace app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getArticleList(Request $request)
    {
        return view('Admin.Article.list');
    }
}
