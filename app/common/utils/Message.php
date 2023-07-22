<?php

/**
 * php
 * 遵循MT协议，开源并可商业使用，没有任何限制
 * @Author:pingo
 * @Date: 2020/10/2 16:37
 * 
 */

namespace app\common\utils;


class Message
{

    const SUCCESS = "操作成功";

    const ERROR = "操作失败";

    const TOKENERROR = "签名错误";

    const TOKENDEFALU = "签名失效";

    const TOKENNOWTIME = "签名过期";

    const TOKENNULL = "未知错误";

    const ROULE = "非法操作";

    const CAPTCHAERROR = "验证码错误";

    const USERNULL = "管理员不存在";
    const APPUSERNULL = "员工不存在";

    const PASSWORDERROR = "用户名或者密码错误";

    const USERSTATUS = "账号已禁用";

    const PARTENTIDMSG = "该菜单下有子节点，请先删除子节点后再进行相关操作！";

    const NOTHING = "内容不存在";

    const USERMessage = "超级管理员不允许删除";
}
