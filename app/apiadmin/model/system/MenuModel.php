<?php


namespace app\apiadmin\model\system;


use think\Model;

class MenuModel extends Model
{
    protected $name="sys_menu";

    protected $pk="menu_id";

    public static function findPermsByUserName($uid)
    {
        return self::alias('m')
            ->join('ky_sys_role_menu rm','rm.menu_id = m.menu_id')
            ->join('sys_member_role ur','rm.role_id = ur.role_id')
            ->join('ky_sys_role ro','ur.role_id = ro.role_id')
            ->join('sys_member u','ur.uid = u.uid')
            ->where('u.uid',$uid)
            ->where('m.status',0)
            ->select();
    }


    /**
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 查询超级管理员的权限
     */
    public static function findAdminMenu(){
        return self::where('status',0)
            ->where('type','in','0,1')
            ->order('order_by asc')
            ->select();
    }


    /**
     * @param $uid
     * @return mixed
     * 查询管理员的权限
     */
    public static function findMemberMenu($uid){
        return self::alias('m')
            ->join('ky_sys_role_menu rm','rm.menu_id = m.menu_id')
            ->join('sys_member_role ur','rm.role_id = ur.role_id')
            ->join('ky_sys_role ro','ur.role_id = ro.role_id')
            ->join('sys_member u','ur.uid = u.uid')
            ->where('u.uid',$uid)
            ->where('m.status',0)
            ->where('m.type','in','0,1')
            ->select();
    }


    /**
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 查询所有菜单
     */
    public static function findByAll()
    {
      return self::order('order_by asc')->select();
    }



    public static function findByTypeAll()
    {
        return self::where('type','in','0,1')->select();
    }


    /**
     * @param $param
     * 添加
     */
    public static function add($param)
    {
        $menuModel = new MenuModel();
        $menuModel->save($param);
    }


    /**
     * @param $param
     * 修改
     */
    public static function edit($param)
    {
        self::update($param,['menu_id'=>$param['menu_id']]);
    }


    public static function del($id)
    {
        self::destroy($id);
    }


    public static function findByMenuId($id)
    {
        return self::where('menu_id',$id)->find();
    }


    public static function findByParentId($id)
    {
        return self::where('parent_id',$id)->find();
    }


    public static function changeStatus($id,$status)
    {
        self::where('menu_id',$id)->update(['status'=>$status]);
    }


    public static function changeOrder($model)
    {
        self::where('menu_id',$model['id'])->update(['order_by'=>$model['num']]);
    }
}