<?php


namespace app\apiadmin\controller\system;



use app\apiadmin\service\system\RoleService;
use app\common\controller\BaseController;

class Role extends BaseController
{

    public function index(){
        $param = $this->request->post();
        $result = RoleService::list($param);
        return $result;
    }

    public function add(){
        $param = $this->request->post();
        $param['creat_time']=date('Y-m-d H:i:s',time());
        $param['creat_by']=$this->request->userName;
        $result = RoleService::add($param);
        return $result;
    }


    public function del($id){
        $result = RoleService::del($id);
        return $result;
    }

    public function selectRoleMenuId($id){
       $result = RoleService::selectRoleMenuId($id);
       return $result;
    }

    public function edit(){
        $param = $this->request->post();
        $param['update_by']=$this->request->userName;
        $param['update_time']=date('Y-m-d H:i:s',time());
        $result = RoleService::edit($param);
        return $result;
    }


    public function selectRole(){
        $result = RoleService::selectRole();
        return $result;
    }

}