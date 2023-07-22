<?php


namespace app\apiadmin\controller\article;


use app\apiadmin\service\article\ContentService;
use app\common\controller\BaseController;

class Content extends BaseController
{



    public function index()
    {
        $param = $this->request->post();

        $result = ContentService::list($param);
        return $result;
    }


    public function add()
    {
        $param = $this->request->post();
        $result = ContentService::add($param);
        return $result;
    }

    public function getUpdateInfo()
    {
        $id = $this->request->post("id/d");

        $result = ContentService::getUpdateInfo($id);
        return $result;
    }

    public function updateExt()
    {
        $param = $this->request->post();

        $result = ContentService::updateExt($param);
        return $result;
    }

    public function edit()
    {
        $param = $this->request->post();
        $result = ContentService::edit($param);
        return $result;
    }

    public function del($id)
    {
        $result = ContentService::del($id);
        return $result;
    }
}
