<?php


namespace app\apiadmin\model\article;


use think\Model;

class ContentModel extends Model
{

    protected $name = "article_content";

    protected $pk = "id";

    protected $type = [
        "state" => 'boolean',
    ];

    public function cateInfo()
    {
        return $this->hasOne(CategoryModel::class, 'id', 'cate_id');
    }
}
