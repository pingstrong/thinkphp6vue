<?php


namespace app\apiadmin\service\system;


use app\apiadmin\model\system\RoleMenuModel;
use app\apiadmin\model\system\RoleModel;
use app\apiadmin\validate\system\RoleValidate;
use app\common\utils\Res;

class RoleService
{

    public static function list($param){
        $limit = (int)$param['pageSize'];
        $offset = ($param['pageNumber']-1)*$limit;
        $keyword = $param['keyword'];
        $map=[];
        if($keyword){
            $map[]=['role_name','like','%'.$keyword.'%'];
        }
        $result = RoleModel::pageMap($map,$offset,$limit);
        $total = RoleModel::pageMapCount($map);
        $data=[
            'list'=>$result,
            'total'=>$total
        ];
        return Res::ok($data);
    }

    public static function add($param){
        try {
           $validate = new RoleValidate();
            if (!$validate->check($param)) {
                return Res::error($validate->getError());
            }
          $roleId = RoleModel::add($param);
          foreach ($param['rules'] as $k=>$v){
              $data=[
                  'role_id'=>$roleId,
                  'menu_id'=>$v
              ];
              RoleMenuModel::add($data);
          }
          return  Res::ok();
        }catch (\PDOException $e){
            return Res::error($e->getMessage());
        }
    }


    public static function del($id){
        try {
            if($id==1){
                return  Res::error("系统默认超级管理不允许删除");
            }
            RoleModel::del($id);
            RoleMenuModel::delByRoleId($id);
            return  Res::ok();
        }catch (\PDOException $e){
            return Res::error($e->getMessage());
        }
    }

    public static function selectRoleMenuId($id){
        $result = RoleMenuModel::findByRoleId($id);
        $data=[];
        foreach ($result as $k=>$v){
            $data[$k]=$v['menu_id'];
        }
        return Res::ok($data);
    }


    public static function edit($param){
        try {
            $validate = new RoleValidate();
            if (!$validate->check($param)) {
                return Res::error($validate->getError());
            }
            RoleModel::edit($param);
            RoleMenuModel::delByRoleId($param['role_id']);
            foreach ($param['rules'] as $k=>$v){
                $data=[
                    'role_id'=>$param['role_id'],
                    'menu_id'=>$v
                ];
                RoleMenuModel::add($data);
            }
            return  Res::ok();
        }catch (\PDOException $e){
            return Res::error($e->getMessage());
        }
    }

    public static function selectRole(){
         $result = RoleModel::findByStatusRole(0);
         return Res::ok($result);
    }

}