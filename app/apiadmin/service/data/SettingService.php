<?php


namespace app\apiadmin\service\data;

use think\facade\Db;

use think\facade\Config;


class SettingService
{

    public static function getListByKey($key): array
    {
        $data = [];
        $list = Db::name("setting")->where(["skey" => $key, 'state' => 1])->select();
        if ($list) {
            foreach ($list as $key => $row) {
                # code...
                $meta = "";
                $value = $row["data"];
                if (in_array($row["type"], ["radio", "checkbox"])) {
                    $meta = json_decode($row["metadata"], true);
                }
                if (in_array($row["type"], ["switch"])) {
                    $value = boolval($row["data"]);
                }
                if (in_array($row["type"], ["images", "image", "checkbox"])) {
                    $value = json_decode($row["data"], true);
                }
                if ($row["type"] == "radio") {
                    $value = intval($row["data"]);
                }

                $data[] = [
                    "id" => $row["id"],
                    "name" => $row["item"],
                    "meta" => $meta,
                    "title" => $row["title"],
                    "type" => $row["type"],
                    "value" => $value,
                ];
            }
        }
        return $data;
    }


    public static  function setItem($skey, $data)
    {
        foreach ($data as  $row) {
            # code...
            $val = $row["value"];
            if (in_array($row['type'], ["images", "image", "checkbox"])) {
                $val = json_encode($row["value"]);
            }
            if ($row['type'] == "switch") {
                $val = intval($val);
            }
            Db::name("setting")->where(["skey" => $skey, "item" => $row["name"]])->update(["data" => $val]);
        }
        return [];
    }

    public static  function getTab($type = 'base')
    {
        if ($type == "base") {
            $data = [
                ["name" => "web", "title" => "基本信息"],
                ["name" => "kefu", "title" => "客服信息"],
                ["name" => "payment", "title" => "支付配置"],
                ["name" => "sms", "title" => "短信配置"],

            ];
        } else {
            $data = [
                ["name" => "promotion", "title" => "三级分销"],
                ["name" => "withdraw", "title" => "提现设置"],

            ];
        }

        return $data;
    }
}
