<?php


namespace app\apiadmin\validate\system;


use think\Validate;

class RoleValidate extends Validate
{

    protected $rule = [
        'role_name'  =>  'require',


    ];

    protected $message = [
        'role_name.require'=>'角色名称必填~~',

    ];

}