<?php


namespace app\apiadmin\controller\system;


use app\apiadmin\service\system\MemberService;
use app\apiadmin\service\system\MenuService;
use app\common\controller\BaseController;

class Menu extends BaseController
{

    /**
     * @return \think\response\Json
     * 读取用户的菜单
     */
    public function getRouter(){
       $resutl = MenuService::menuRouter($this->request->uid);
       return $resutl;
    }

    public function menuTree(){
        $result = MenuService::tree();
        return $result;
    }


    public function add(){
        $param = $this->request->post();
        $param['creat_time']=date('Y-m-d H:i:s',time());
        $param['creat_by']=$this->request->userName;
        $result = MenuService::add($param);
        return $result;
    }


    public function edit(){
        $param = $this->request->post();
        $param['update_time']=date('Y-m-d H:i:s',time());
        $param['update_by']=$this->request->userName;
        $result = MenuService::edit($param);
        return $result;
    }


    public function del($id){
      $result = MenuService::del($id);
      return $result;
    }

    public function changeStatus($id){
      $result = MenuService::changeStatus($id);
      return $result;
    }

    public function changeOrder(){
        $param = $this->request->post();
        $result = MenuService::changeOrder($param);
        return $result;
    }
}