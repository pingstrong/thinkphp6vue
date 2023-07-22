<?php


namespace app\apiadmin\service\article;

use app\apiadmin\model\article\CategoryModel;
use app\apiadmin\model\system\MemberModel;
use app\apiadmin\model\system\MemberRoleModel;
use app\apiadmin\model\system\MenuModel;
use app\apiadmin\validate\article\CategoryValidate;
use app\apiadmin\validate\system\MemberValidate;
use app\common\service\JwtService;
use app\apiadmin\validate\system\LoginValidate;
use app\common\utils\Message;
use app\common\utils\Res;

class CategoryService
{




    public static function getAll($param)
    {
        $list = CategoryModel::select();
        // 获取总记录数
        $total = CategoryModel::count();
        $data = [
            'list' => $list,
            'total' => $total,
        ];
        return Res::ok($data);
    }


    public static function list($param)
    {
        $limit = (int)$param['pageSize'];
        $page = intval($param['page']);
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = CategoryModel::order('id', 'desc')->page($page, $limit)->select();
        // 获取总记录数
        $total = CategoryModel::count();
        $data = [
            'list' => $list,
            'total' => $total
        ];
        return Res::ok($data);
    }


    public static function add($param)
    {
        try {
            $validate = new CategoryValidate();
            if (!$validate->scene("add")->check($param)) {
                return Res::error($validate->getError());
            }
            CategoryModel::create($param);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function edit($param)
    {
        try {
            $validate = new CategoryValidate();
            if (!$validate->scene("edit")->check($param)) {
                return Res::error($validate->getError());
            }
            $update_field = [
                "title" => $param['title'],
                "thumb" => $param['thumb'],

            ];
            CategoryModel::where("id", $param["id"])->update($update_field);

            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function getUpdateInfo($id = 0)
    {
        try {
            $result = CategoryModel::find($id);
            return  Res::ok($result);
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static  function del($id)
    {
        try {
            CategoryModel::destroy($id);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }
}
