<?php


namespace app\apiadmin\model\article;


use think\Model;

class CategoryModel extends Model
{

    protected $name = "article_category";

    protected $pk = "id";

    protected $autoWriteTimestamp = "datetime";
    // 定义时间戳字段名
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
}
