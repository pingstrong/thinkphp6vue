<?php


namespace app\apiadmin\model\system;


use think\Model;

class DeptModel extends Model
{

    protected $name="sys_dept";

    protected $pk="dept_id";


    public static function findByAll()
    {
        return self::order('order_by asc')->select();
    }


    public static function add($param)
    {
        $deptModel = new DeptModel();
        $deptModel->save($param);

    }


    public static function del($id)
    {
        self::destroy($id);
    }

    public static function edit($model)
    {
        self::update($model, ['dept_id' => $model['dept_id']]);
    }


    public static function findByParentId($id)
    {
        return self::where('parent_id',$id)->find();
    }




    public static function changeOrder($model)
    {
        self::where('dept_id',$model['id'])->update(['order_by'=>$model['num']]);
    }


    public static function findByDeptId($id)
    {
        return self::where('dept_id',$id)->find();
    }
}