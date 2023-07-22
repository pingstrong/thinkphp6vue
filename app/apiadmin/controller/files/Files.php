<?php


namespace app\apiadmin\controller\files;


use app\apiadmin\service\files\FilesService;
use app\common\controller\BaseController;

class Files extends BaseController
{

    public function index(){
        $param = $this->request->post();
        $result = FilesService::list($param);
        return $result;
    }


    public function del($id){
        $result = FilesService::del($id);
        return $result;
    }

    public function batchRemove(){
        $param = $this->request->post("ids/a");
        $result = FilesService::batchRemove($param);
        return $result;
    }
}