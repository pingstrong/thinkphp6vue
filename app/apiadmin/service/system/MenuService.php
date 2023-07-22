<?php


namespace app\apiadmin\service\system;


use app\apiadmin\model\system\MemberRoleModel;
use app\apiadmin\model\system\MenuModel;
use app\common\service\RouterService;
use app\common\service\TreeService;
use app\apiadmin\validate\system\MenuValidate;
use app\common\utils\Message;
use app\common\utils\Res;

class MenuService
{

    public static function menuRouter($uid)
    {
        $roleIds = [];
        $roleList = MemberRoleModel::findByMemberRole($uid);
        foreach ($roleList as $k => $v) {
            $roleIds[] = $v['role_id'];
        }
        if (in_array(1, $roleIds)) {
            $result = MenuModel::findAdminMenu();
        } else {
            $result = MenuModel::findMemberMenu($uid);
        }
        $routerList = RouterService::MakeRouter($result);
        return Res::ok($routerList);
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function tree()
    {
        $menuList = MenuModel::findByAll();
        $menuTree = TreeService::MakeMenuTree($menuList, 'menu_id', 'parent_id');
        $menupTree = MenuModel::findByTypeAll();
        $pTree = TreeService::MakeTreePid($menupTree, 'menu_id', 'parent_id');
        $data = [
            'menuTree' => $menuTree,
            'pTree' => $pTree
        ];
        return Res::ok($data);
    }


    /**
     * @param $param
     * @return \think\response\Json
     * 添加
     */
    public static function add($param)
    {
        try {
            MenuModel::add($param);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    /**
     * @param $param
     * @return \think\response\Json
     * 修改的服务
     */
    public static function edit($param)
    {
        try {
            $validate = new MenuValidate();
            if (!$validate->check($param)) {
                return Res::error($validate->getError());
            }
            MenuModel::edit($param);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function del($id)
    {
        try {

            $result = MenuModel::findByMenuId($id);
            if (empty($result)) {
                return Res::error(Message::NOTHING);
            }
            $list = MenuModel::findByParentId($id);
            if ($list) {
                return  Res::error(Message::PARTENTIDMSG);
            }
            MenuModel::del($id);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function changeStatus($id)
    {
        try {
            $result = MenuModel::findByMenuId($id);
            $status = $result['status'] == 0 ? 1 : 0;
            MenuModel::changeStatus($id, $status);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function changeOrder($param)
    {
        try {
            MenuModel::changeOrder($param);
            return Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }
}
