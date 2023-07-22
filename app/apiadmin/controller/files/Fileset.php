<?php


namespace app\apiadmin\controller\files;


use app\apiadmin\model\files\FilesSetModel;
use app\apiadmin\service\files\FilesSetService;
use app\common\controller\BaseController;
use app\common\utils\Res;

class Fileset extends BaseController
{

    public function add(){
        $param = $this->request->post();
        $result = FilesSetService::addEdit($param);
        return $result;
    }

    public function index(){
       $result = FilesSetModel::findByid();
       return Res::ok($result);
    }

}