<?php


namespace app\apiadmin\controller\system;


use app\apiadmin\service\system\DeptService;
use app\common\controller\BaseController;

class Dept extends BaseController
{

    public function deptTree(){
        $result = DeptService::tree();
        return $result;
    }

    public function add(){
        $param = $this->request->post();
        $param['creat_time']=date('Y-m-d H:i:s',time());
        $param['creat_by']=$this->request->userName;
        $result = DeptService::add($param);
        return $result;
    }

    public function edit(){
        $param = $this->request->post();
        $param['update_time']=date('Y-m-d H:i:s',time());
        $param['update_by']=$this->request->userName;
        $result = DeptService::edit($param);
        return $result;
    }


    public function del($id){
        $result = DeptService::del($id);
        return $result;
    }

    public function changeOrder(){
        $param = $this->request->post();
        $result = DeptService::changeOrder($param);
        return $result;
    }

}