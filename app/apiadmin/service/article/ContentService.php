<?php


namespace app\apiadmin\service\article;

use app\apiadmin\model\article\ContentModel;
use app\apiadmin\model\system\MemberModel;
use app\apiadmin\model\system\MemberRoleModel;
use app\apiadmin\model\system\MenuModel;
use app\apiadmin\validate\article\ContentValidate;
use app\apiadmin\validate\system\MemberValidate;
use app\common\service\JwtService;
use app\apiadmin\validate\system\LoginValidate;
use app\common\utils\Message;
use app\common\utils\Res;

class ContentService
{




    public static function list($param)
    {
        $limit = (int)$param['pageSize'];
        $page = intval($param['page']);
        $search = $param['search'] ?? [];
        $where = [];
        if ($search) {
            if (isset($search['state']) && $search["state"] !== "") {
                $where[] = ['state', '=',  $search['state']];
            }
            if (!empty($search['title'])) {
                $where[] = ['title', 'like', "%" . $search['title'] . "%"];
            }
            if (!empty($search['cate_id'])) {
                $where[] = ['cate_id', '=', $search['cate_id']];
            }
        }

        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = ContentModel::where($where)->with(['cateInfo'])->order('id', 'desc')->page($page, $limit)->select();
        // 获取总记录数
        $total = ContentModel::where($where)->count();
        $data = [
            'list' => $list,
            'total' => $total
        ];
        return Res::ok($data);
    }


    public static function add($param)
    {
        try {
            $validate = new ContentValidate();
            if (!$validate->scene("add")->check($param)) {
                return Res::error($validate->getError());
            }

            ContentModel::create($param);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function updateExt($param)
    {
        try {
            $validate = new ContentValidate();
            if (!$validate->scene("updateExt")->check($param)) {
                return Res::error($validate->getError());
            }
            $val = $param['value'];
            if ($param["field"] === 'state') {
                $val = $param["value"] === "true" ? 1 : 0;
            }

            ContentModel::update([$param['field'] => $val], ['id' => $param['id']]);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function getUpdateInfo($id = 0)
    {
        try {
            $result = ContentModel::find($id);
            return  Res::ok($result);
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function edit($param)
    {
        try {
            $validate = new ContentValidate();
            if (!$validate->scene("edit")->check($param)) {
                return Res::error($validate->getError());
            }
            ContentModel::update($param, ["id" => $param['id']]);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static  function del($id)
    {
        try {

            ContentModel::destroy($id);

            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }
}
