<?php


namespace app\apiadmin\validate\system;


use think\Validate;
use app\common\service\CaptchaService;

class LoginValidate extends Validate
{

    protected $rule = [
        'user_name'  =>  'require|unique:sys_member',
        'password' =>  'require',
        'codekey' =>  'require',
        'code' => 'require|checkCode'
    ];
    protected $message = [
        'user_name.require' => '管理员账号必填~~',
        'password.require' => '密码必填~~',
        'code.require' => '验证码不能为空',
        'code.checkCode' => '验证码错误',
    ];


    public function checkCode($value, $rule, $data = [])
    {
        return  app()->make(CaptchaService::class)->check($data['codekey'], $value);
    }

    public function sceneApi()
    {
        return $this->only(['user_name', 'password', 'code'])
            ->remove('user_name', 'unique');
    }

    public function sceneLogin()
    {
        return $this->only(['user_name', 'password', 'code', 'codekey'])
            ->remove('user_name', 'unique');
    }
}
