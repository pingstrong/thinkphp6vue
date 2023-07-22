<?php


namespace app\apiadmin\service\system;


use app\apiadmin\controller\system\Dept;
use app\apiadmin\model\system\DeptModel;
use app\apiadmin\validate\system\DeptValidate;
use app\common\service\TreeService;
use app\common\utils\Message;
use app\common\utils\Res;

class DeptService
{

    public static function tree()
    {
        $menuList = DeptModel::findByAll();
        $menuTree = TreeService::MakeTree($menuList, 'dept_id', 'parent_id');
        $data = ['deptTree' => $menuTree];
        return Res::ok($data);
    }




    public static function add($param)
    {
        try {
            $validate = new DeptValidate();
            if (!$validate->check($param)) {
                return  Res::error($validate->getError());
            }

            DeptModel::add($param);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function edit($param)
    {
        try {
            $validate = new DeptValidate();
            if (!$validate->check($param)) {
                return Res::error($validate->getError());
            }
            DeptModel::edit($param);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function del($id)
    {
        try {

            $result = DeptModel::findByDeptId($id);
            if (empty($result)) {
                return Res::error(Message::NOTHING);
            }
            $list = DeptModel::findByParentId($id);
            if ($list) {
                return  Res::error(Message::PARTENTIDMSG);
            }
            DeptModel::del($id);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function changeOrder($param)
    {
        try {
            DeptModel::changeOrder($param);
            return Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }
}
