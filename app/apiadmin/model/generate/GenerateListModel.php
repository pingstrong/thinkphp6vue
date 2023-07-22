<?php


namespace app\apiadmin\model\generate;


use think\Model;

class GenerateListModel extends Model
{

    protected $name="gen_list";

    protected $pk='glid';


    public static function findByGid($gid)
    {
        return self::where('gid',$gid)->select();
    }


    public static function add($param){
        $generateListModel = new GenerateListModel();
        $generateListModel->save($param);
    }

    public static function edit($param)
    {
        self::update($param,['gid'=>$param['gid']]);
    }


    public static function del($id){
        self::where('gid',$id)->delete();
    }

}