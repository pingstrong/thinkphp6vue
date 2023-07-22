<?php


namespace app\apiadmin\controller\data;


use app\apiadmin\service\data\BackupService;
use app\common\controller\BaseController;
use app\common\utils\Res;

class Datas extends BaseController
{

    public function index(){
        $param = $this->request->post();
        $limit = (int)$param['pageSize'];
        $offset = ($param['pageNumber']-1)*$limit;
        $db = new BackupService();
        $list = $db->dataList();
        foreach ($list as $k=>$v){
            $name= substr($v['name'],strpos($v['name'],'_')+1);
            $list[$k]['stname'] = substr($name,strpos($name,'_')+1);
        }
        $article = array_slice($list,$offset,$limit);
        $data=[
            'list'=>$article,
            'total'=>count($list),
        ];
        return Res::ok($data);
    }

}