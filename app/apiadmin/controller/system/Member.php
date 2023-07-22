<?php


namespace app\apiadmin\controller\system;


use app\apiadmin\service\system\MemberService;
use app\common\controller\BaseController;

class Member extends BaseController
{

    public function info()
    {
        $uid = $this->request->uid;
        $userName = $this->request->userName;
        $face = $this->request->face;
        $result = MemberService::memberInfo($uid, $userName, $face);
        return $result;
    }

    public function index()
    {
        $param = $this->request->post();
        $result = MemberService::list($param);
        return $result;
    }


    public function add()
    {
        $param = $this->request->post();
        $param['creat_time'] = date('Y-m-d H:i:s', time());
        $param['creat_by'] = $this->request->userName;
        $param['password'] = md5($param['password']);
        $result = MemberService::add($param);
        return $result;
    }

    public function edit()
    {
        $param = $this->request->post();
        $param['update_by'] = $this->request->userName;
        $param['update_time'] = date('Y-m-d H:i:s', time());
        $result = MemberService::edit($param);
        return $result;
    }

    public function del($id)
    {
        $result = MemberService::del($id);
        return $result;
    }


    public function updateProfile()
    {
        $uid = $this->request->uid;
        $nick_name = $this->request->param("nickName");
        $headerImg = $this->request->param("headerImg");
        $phone = $this->request->param("phone");

        $result = MemberService::updateProfile($uid, $nick_name, $headerImg, $phone);
        return $result;
    }

    public function changePwd()
    {
        $uid = $this->request->uid;
        $new_pwd = $this->request->param("new_pwd");
        $old_pwd = $this->request->param("old_pwd");
        $phone = $this->request->param("phone");

        $result = MemberService::changePwd($uid, $new_pwd, $old_pwd);
        return $result;
    }
}
