<?php

/**
 * php
 * 遵循MT协议，开源并可商业使用，没有任何限制
 * @Author:pingo
 * @Date: 2020/10/2 16:14
 * 
 */

namespace app\common\utils;


class ErrorCode
{
    const SUCCESS       = 200;
    const ERROR         = 201;
    const TOKENERROR    = 401;
    const SYSTEM_ERROR  = 500;
    const NO_AUTH       = 403;
}
