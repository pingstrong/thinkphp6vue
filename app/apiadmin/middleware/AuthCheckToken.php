<?php

/**
 * php
 * 遵循MT协议，开源并可商业使用，没有任何限制
 * @Author:pingo
 * @Date: 2020/10/2 16:11
 * 
 */

namespace app\apiadmin\middleware;


use app\common\service\JwtService;
use app\common\utils\ErrorCode;
use app\common\utils\Message;
use app\common\utils\Res;

class AuthCheckToken
{
    public function handle($request, \Closure $next)
    {
        $token = trim(ltrim($request->header('Authorization'), 'Bearer'));
        if (empty($token)) {
            return Res::error(Message::ROULE);
        }
        $result = JwtService::checkToken($token);
        if ($result['code'] != ErrorCode::SUCCESS) {
            return Res::jsonResult($result);
        }
        $request->authInfo = $result;
        $request->uid = $result['data']->uid;
        $request->userName = $result['data']->user_name;
        $request->face = $result['data']->face;
        return $next($request);
    }
}
