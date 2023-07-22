<?php


namespace app\apiadmin\validate\system;


use think\Validate;

class MenuValidate extends Validate
{

    protected $rule = [
        'menu_name'  =>  'require',
        'parent_id' =>  'require',

    ];
    protected $message = [
        'menu_name.require'=>'菜单名称不能为空~~',
        'parent_id.require'=>'上级菜单不能为空~~',

    ];

}