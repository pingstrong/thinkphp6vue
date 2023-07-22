<?php

namespace app\apiadmin\controller\data;


use app\apiadmin\service\data\ConsoleService;
use app\common\controller\BaseController;
use app\common\utils\Res;

class Console extends BaseController
{

    public function getStatis()
    {
        $result = ConsoleService::getStatis();
        return Res::ok($result);
    }

    public function getChart()
    {
        $result = ConsoleService::getChart();
        return Res::ok($result);
    }
}
