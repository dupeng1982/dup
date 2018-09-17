<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Date;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //数据封装
    protected function resp($code, $data)
    {
        return response()->json([
            'code' => $code,
            'data' => $data,
        ]);
    }

    //数据封装
    protected function resp_long($code, $data)
    {
        return response()->json([
            'code' => $code,
            'data' => json_encode($data),
        ]);
    }

    //时间段参数规则化
    protected function getTimeArr($string)
    {
        $arr = explode(',', $string);
        sort($arr);
        return $arr;
    }
}
