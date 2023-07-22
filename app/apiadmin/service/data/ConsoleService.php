<?php


namespace app\apiadmin\service\data;

use think\facade\Db;

use think\facade\Config;


class ConsoleService
{

    public static function getStatis(): array
    {
        $data = [
            ["color" => "#40c9c6", "icon" => "peoples", "number" => 1, "title" => "用户总数"],
            ["color" => "#36a3f7", "icon" => "message", "number" => 1, "title" => "订单总数"],
            ["color" => "#f4516c", "icon" => "money", "number" => 1, "title" => "总销售额"],
            ["color" => "#34bfa3", "icon" => "shopping", "number" => 1, "title" => "近七天销售额"],
            ["color" => "#36a3f7", "icon" => "qq", "number" => 1, "title" => "商户总数"],
            ["color" => "#40c9c6", "icon" => "peoples", "number" => 1, "title" => "用户总数"],
            ["color" => "#40c9c6", "icon" => "peoples", "number" => 1, "title" => "用户总数"],

        ];
        return $data;
    }

    public static  function getChart()
    {
        $data = [
            "title" => "用户增长趋势图",
            "x" => ["07-14", "07-15", "07-16"],
            "y" => [11, 22, 33],
        ];
        return $data;
    }
}
