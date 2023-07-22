<?php


namespace app\apiadmin\model\files;


use think\Model;

class FilesSetModel extends Model
{

    protected $name="files_set";

    protected $pk="sid";

    public static function add($param)
    {
        $filesetModel = new FilesSetModel();
        $filesetModel->save($param);
    }

    public static function edit($param)
    {
       self::update($param,['sid'=>$param['sid']]);
    }


    public static function findByid()
    {
        return self::find(1);
    }
}