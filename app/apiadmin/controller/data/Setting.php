<?php

namespace app\apiadmin\controller\data;


use app\apiadmin\service\data\SettingService;
use app\common\controller\BaseController;
use app\common\utils\Res;

class Setting extends BaseController
{

    public function getListByKey()
    {
        $key = $this->request->param("key", "web");
        $result = SettingService::getListByKey($key);
        return Res::ok($result);
    }

    public function setItem()
    {
        $key = $this->request->param("key");
        $data = $this->request->param("data");
        $result = SettingService::setItem($key, $data);
        return Res::ok($result);
    }

    public function getTab()
    {
        $type = $this->request->param("type", "web");
        $result = SettingService::getTab($type);
        return Res::ok($result);
    }
}
