<?php


namespace app\apiadmin\controller\generate;


use app\apiadmin\service\generate\GenerateService;
use app\common\controller\BaseController;
use app\common\utils\Res;

class Generate extends BaseController
{


    public function index(){
      $param = $this->request->post();
      $result =GenerateService::findGen($param['name']);
      return $result;
    }

    public function add(){
        $param = $this->request->post();
        $result = GenerateService::add($param);
        return $result;
    }






    /**
     * @return \think\response\Json
     * 查询数据的库表
     */
    public function selectTable(){
        $tables = GenerateService::tables();
        return Res::ok($tables);
    }

    public function selectCloums(){
        $param = $this->request->post();
        $result = GenerateService::columns($param['name']);
        foreach ($result as $k=>$v){
            $result[$k]['type']=0;
            $result[$k]['val']=0;
        }
        return Res::ok($result);
    }

    public function getData(){
        $param = $this->request->post();
        $param['name']=ucfirst($param['formdata']['name']);//将首字母大写
        $param['names']=lcfirst($param['formdata']['name']);//将首字母小写
        $param['tables']=substr($param['formdata']['tables'],strpos($param['formdata']['tables'],'_')+1);
        $param['type']=$param['formdata']['type'];
        $result = GenerateService::genReady($param);
        $res = GenerateService::genModel($result);
        $rescontroller = GenerateService::genController($result);
        $resservice = GenerateService::genService($result);
        $data=[
            'model'=>$res,
            'controller'=>$rescontroller,
            'service'=>$resservice
        ];
        return Res::ok($data);
    }



}