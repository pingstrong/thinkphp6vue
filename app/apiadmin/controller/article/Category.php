<?php


namespace app\apiadmin\controller\article;


use app\apiadmin\service\article\CategoryService;
use app\common\controller\BaseController;

class Category extends BaseController
{


    public function index()
    {
        $param = $this->request->post();

        $result = CategoryService::list($param);
        return $result;
    }

    public function getAll()
    {
        $param = $this->request->post();

        $result = CategoryService::getAll($param);
        return $result;
    }


    public function add()
    {
        $param = $this->request->post();

        $result = CategoryService::add($param);
        return $result;
    }

    public function edit()
    {
        $param = $this->request->post();
        $result = CategoryService::edit($param);
        return $result;
    }

    public function getUpdateInfo()
    {
        $id = $this->request->post("id/d");

        $result = CategoryService::getUpdateInfo($id);
        return $result;
    }

    public function del($id)
    {
        $result = CategoryService::del($id);
        return $result;
    }
}
