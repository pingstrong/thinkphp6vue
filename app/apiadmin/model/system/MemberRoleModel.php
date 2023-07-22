<?php


namespace app\apiadmin\model\system;


use think\Model;

class MemberRoleModel extends Model
{
    protected $name="sys_member_role";

    /**
     * @param $uid
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 根据 UID查询用户的角色
     */
     public static function findByMemberRole($uid)
     {
        return self::where('uid',$uid)->select();
     }


     public static function add($model)
     {
         $mroleModel = new MemberRoleModel();
         $mroleModel->save($model);
     }


     public static function delByUid($uid){
         self::where('uid',$uid)->delete();
     }
}