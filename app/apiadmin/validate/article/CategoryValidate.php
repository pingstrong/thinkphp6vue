<?php


namespace app\apiadmin\validate\article;


use think\Validate;

class CategoryValidate extends Validate
{

    protected $rule = [
        'title'  =>  'require',
        'thumb'  =>  'require',
        'id'    =>  'require|integer',
    ];

    protected $message = [
        'title.require' => '标题必填~~',
        'thumb.require' => '缩略图必填~~',
    ];

    protected $scene = [
        'add'  =>  ['title', 'thumb'],
        'edit'  =>  ['id', 'title', 'thumb'],
    ];
}
