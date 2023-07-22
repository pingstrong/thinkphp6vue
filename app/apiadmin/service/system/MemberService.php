<?php


namespace app\apiadmin\service\system;


use app\apiadmin\model\system\MemberModel;
use app\apiadmin\model\system\MemberRoleModel;
use app\apiadmin\model\system\MenuModel;
use app\apiadmin\validate\system\MemberValidate;
use app\common\service\JwtService;
use app\apiadmin\validate\system\LoginValidate;
use app\common\utils\Message;
use app\common\utils\Res;

class MemberService
{


    public static function logout($param)
    {
        return Res::ok(1);
    }

    public static function login($param)
    {
        try {
            $validate = new LoginValidate();
            if (!$validate->scene('login')->check($param)) {
                return Res::error($validate->getError());
            }
            $result = MemberModel::findByUserName($param['user_name']);
            if (empty($result)) {
                return Res::error(Message::USERNULL);
            }
            if (md5($param['password']) != $result['password']) {
                return Res::error(Message::PASSWORDERROR);
            }
            if ($result['status'] != 1) {
                return Res::error(Message::USERSTATUS);
            }
            $token = JwtService::createToken($result);
            return Res::ok($token);
        } catch (\PDOException $e) {
            return  Res::error($e->getMessage());
        }
    }


    /**
     * @param $uid
     * @param $userName
     * @param $face
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 查询用户信息
     */

    public static function memberInfo($uid, $userName, $face)
    {
        try {
            $roleList = MemberRoleModel::findByMemberRole($uid);
            $roleIds = [];
            foreach ($roleList as $k => $v) {
                $roleIds[] = $v['role_id'];
            }
            if (in_array(1, $roleIds)) {
                $result[0] = ['perms' => '*'];
            } else {
                $result = MenuModel::findPermsByUserName($uid);
            }
            $node = [];
            foreach ($result as $k => $v) {
                if ($v['perms']) {
                    array_push($node, $v['perms']);
                }
            }
            $member = MemberModel::find($uid);
            $data['perms'] = $node;
            $data['userInfo'] = [
                'username' => $member['user_name'],
                'face' => $member['face'],
                'nick_name' => $member['nick_name'],
                'phone' => $member['phone'],

            ];
            return  Res::ok($data);
        } catch (\PDOException $e) {
            return  Res::error($e->getMessage());
        }
    }




    public static function list($param)
    {
        $limit = (int)$param['pageSize'];
        $offset = ($param['pageNumber'] - 1) * $limit;
        $keyword = $param['keyword'];
        $map = [];
        if ($keyword) {
            $map[] = ['user_name|phone', 'like', '%' . $keyword . '%'];
        }
        $result = MemberModel::pageMap($map, $offset, $limit);
        $total = MemberModel::pageMapCount($map);
        $data = [
            'list' => $result,
            'total' => $total
        ];
        return Res::ok($data);
    }


    public static function add($param)
    {
        try {
            $validate = new MemberValidate();
            if (!$validate->check($param)) {
                return Res::error($validate->getError());
            }

            $uid = MemberModel::add($param);
            foreach ($param['role'] as $k => $v) {
                $data = [
                    'role_id' => $v,
                    'uid' => $uid
                ];
                MemberRoleModel::add($data);
            }
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function updateProfile($uid, $nick_name, $headerImg, $phone)
    {
        try {


            MemberModel::update([
                "nick_name" => $nick_name,
                "face"  => $headerImg,
                "phone" => $phone,
            ], [
                "uid" => $uid,
            ]);

            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function changePwd($uid, $new_pwd, $old_pwd)
    {
        try {

            $member = MemberModel::find($uid);
            if (empty($member)) {
                return Res::error("不存在用户");
            }
            if ($member["password"] !== md5($old_pwd)) {
                return Res::error("旧密码错误");
            }

            MemberModel::update([
                "password" => md5($new_pwd),
            ], [
                "uid" => $uid,
            ]);

            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function edit($param)
    {
        try {
            $validate = new MemberValidate();
            if (!$validate->check($param)) {
                return Res::error($validate->getError());
            }
            $reslut  = MemberModel::findByUid($param['uid']);
            if ($param['password'] != $reslut['password']) {
                $param['password'] = md5($param['password']);
            }
            MemberModel::edit($param);
            MemberRoleModel::delByUid($param['uid']);
            foreach ($param['role'] as $k => $v) {
                $data = [
                    'role_id' => $v,
                    'uid' => $param['uid']
                ];
                MemberRoleModel::add($data);
            }
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static  function del($id)
    {
        try {
            if ($id == 1) {
                return  Res::error("系统默认超级管理员不允许删除");
            }
            MemberModel::del($id);
            MemberRoleModel::delByUid($id);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }
}
