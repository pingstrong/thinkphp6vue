<?php


namespace app\apiadmin\model\system;


use think\Model;

class MemberModel extends Model
{

    protected $name="sys_member";

    protected $pk="uid";


    /**
     * @param $userName
     * @return array|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 根据USERNAME查找管理员
     */
    public static function findByUserName($userName)
    {
        return self::where('user_name',$userName)->find();
    }

    public function dept()
    {
        return $this->hasOne(DeptModel::class,'dept_id','dept_id');
    }

    public function roles()
    {
        return $this->hasMany(MemberRoleModel::class,'uid','uid');
    }


    public static function pageMap($map,$offset,$limit){
        return self::with(['dept','roles'])->where($map)->limit($offset,$limit)->order('uid desc')->select();
    }


    public static function pageMapCount($map){
        return self::with('dept')->where($map)->count();
    }

    /**
     * @param $model
     * @return mixed
     * 添加管理员
     */
    public static function add($model)
    {
        $memberModel = new MemberModel();
        $memberModel->save($model);
        return $memberModel->uid;

    }

    public static function edit($param){

        self::update($param, ['uid' => $param['uid']]);


    }


    public static function findByUid($id)
    {
        return self::find($id);
    }

    public static function del($id)
    {
        self::destroy($id);
    }

}