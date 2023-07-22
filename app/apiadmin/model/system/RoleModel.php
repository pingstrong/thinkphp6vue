<?php


namespace app\apiadmin\model\system;


use think\Model;

class RoleModel extends Model
{

    protected $name="sys_role";

    protected $pk="role_id";


    public static function pageMap($map,$offset,$limit){
        return self::where($map)->limit($offset,$limit)->order('role_id desc')->select();
    }


    public static function pageMapCount($map){
        return self::where($map)->count();
    }

    public static function add($param)
    {
        $roleModel = new RoleModel();
        $roleModel->save($param);
        return $roleModel->role_id;
    }


    public static function del($id)
    {
        self::destroy($id);
    }

    public static function edit($model)
    {
        self::update($model, ['role_id' => $model['role_id']]);
    }


    public static function findByStatusRole($status)
    {
        return self::where('status',$status)->order('order_by asc')->select();
    }
}