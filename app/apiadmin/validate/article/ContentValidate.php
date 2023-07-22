<?php


namespace app\apiadmin\validate\article;


use think\Validate;

class ContentValidate extends Validate
{

    protected $rule = [
        'title'  =>  'require',
        'thumb'  =>  'require',
        'content'  =>  'require',
        'cate_id'    =>  'require|integer',
        'field'      => 'require',
        'value'      => 'require',
        'id'    =>  'require|integer',
    ];

    protected $message = [
        'title.require' => '标题必填~~',
        'thumb.require' => '缩略图必填~~',
    ];

    protected $scene = [
        'add'  =>  ['title', 'thumb', 'content', 'cate_id'],
        'edit'  =>  ['id', 'title', 'thumb', 'content'],
        'updateExt'  =>  ['id', 'field', 'value'],
    ];
}
