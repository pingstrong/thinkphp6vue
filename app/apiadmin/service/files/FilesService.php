<?php


namespace app\apiadmin\service\files;


use app\apiadmin\model\files\FilesModel;
use app\common\utils\Res;
use think\facade\Request;

class FilesService
{

    public static function list($param)
    {
        $limit = (int)$param['pageSize'];
        $offset = ($param['page'] - 1) * $limit;
        $keyword = $param['keyWord'] ?? "";

        $map = [];
        if ($keyword) {
            $map[] = ['name', 'like', '%' . $keyword . '%'];
        }
        if ($param['type'] != 3000) {
            $map[] = ['type', '=', $param['type']];
        }
        $result = FilesModel::pageMap($map, $offset, $limit);
        $total = FilesModel::pageMapCount($map);
        $data = [
            'list' => $result,
            'total' => $total
        ];
        return Res::ok($data);
    }

    public static function add($param)
    {
        try {
            FilesModel::add($param);
            return  Res::ok($param);
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }

    public static function del($id)
    {
        try {
            $result = FilesModel::find($id);

            $filename =   public_path() . $result['urls'];
            if (is_file($filename)) {
                unlink($filename);
            }
            FilesModel::del($id);
            return  Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }


    public static function batchRemove($param)
    {
        try {

            foreach ($param as $k => $v) {
                $result = FilesModel::find($v);
                $filesname = public_path() . $result['urls'];
                if (is_file($filesname)) {
                    unlink($filesname);
                }
            }
            FilesModel::del($param);

            return Res::ok();
        } catch (\PDOException $e) {
            return Res::error($e->getMessage());
        }
    }
}
