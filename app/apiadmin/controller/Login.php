<?php


namespace app\apiadmin\controller;


use app\apiadmin\service\system\MemberService;
use app\common\controller\BaseController;
use app\common\service\CaptchaService;

class Login extends BaseController
{

    /**
     * @return mixed
     * 验证码
     */
    public function verify()
    {
        return app()->make(CaptchaService::class)->create();
    }


    public function login()
    {
        $param = $this->request->post();
        $result = MemberService::login($param);
        return $result;
    }

    public function logout()
    {
        $param = $this->request->post();
        $result = MemberService::logout($param);
        return $result;
    }
}
