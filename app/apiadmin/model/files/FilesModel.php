<?php


namespace app\apiadmin\model\files;


use think\Model;

class FilesModel extends Model
{

    protected $name="files";

    protected $pk="fid";

    public static function pageMap($map,$offset,$limit){
        return self::where($map)->limit($offset,$limit)->order('fid desc')->select();
    }


    public static function pageMapCount($map){
        return self::where($map)->count();
    }


    public static function add($param)
    {
        $filesModel = new FilesModel();
        $filesModel->save($param);
    }


    public static function del($id)
    {
        self::destroy($id);
    }



}