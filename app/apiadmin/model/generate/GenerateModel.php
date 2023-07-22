<?php


namespace app\apiadmin\model\generate;


use think\Model;

class GenerateModel extends  Model
{


    protected $name="gen";

    protected $pk="gid";

    public static function findByTabels($param)
    {
        return self::where('tables',$param)->find();
    }

    public static function add($param){
        $generateModel = new GenerateModel();
        $generateModel->save($param);
        return $generateModel->gid;
    }


    public static function edit($param){
        self::update($param, ['gid' => $param['gid']]);
    }

}