<?php


namespace app\apiadmin\model\system;


use think\Model;

class RoleMenuModel extends Model
{
    protected $name="sys_role_menu";


    public static function add($param)
    {
        $roleMenuModel = new RoleMenuModel();
        $roleMenuModel->save($param);
    }

    public static function delByRoleId($id)
    {
        self::where('role_id',$id)->delete();
    }

    public static function findByRoleId($id)
    {
        return self::where('role_id',$id)->select();
    }
}