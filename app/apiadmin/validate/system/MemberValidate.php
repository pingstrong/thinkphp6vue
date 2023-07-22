<?php


namespace app\apiadmin\validate\system;


use think\Validate;

class MemberValidate extends Validate
{

    protected $rule = [
        'user_name'  =>  'require|unique:sys_member',
        'password' =>  'require',
        'role' =>  'require',

    ];
    protected $message = [
        'user_name.require'=>'管理员账号必填~~',
        'password.require'=>'密码必填~~',
        'role.require'=>'角色必填~~',

    ];

}