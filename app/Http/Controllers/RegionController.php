<?php
namespace App\Http\Controllers;

use App\Models\Region\RegionModel;
use Illuminate\Http\Request;

class RegionController
{
    public function __construct()
    {
        $this->region_model = new RegionModel();
    }

    public function getRegionCode($request)
    {
        $where = $this->region_model->getListWhere(['region_name'=>'上海']);
        $region_res = $this->region_model->getOne($where);
        var_dump($region_res);die;
    }
}
