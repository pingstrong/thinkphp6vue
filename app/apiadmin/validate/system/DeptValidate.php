<?php


namespace app\apiadmin\validate\system;


use think\Validate;

class DeptValidate extends Validate
{

    protected $rule = [
        'dept_name'  =>  'require',
        'parent_id' =>  'require',

    ];
    protected $message = [
        'dept_name.require'=>'部门名称不能为空~~',
        'parent_id.require'=>'上级部门不能为空~~',

    ];

}