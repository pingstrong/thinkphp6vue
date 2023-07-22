<?php

/**
 * php
 * 遵循MT协议，开源并可商业使用，没有任何限制
 * @Author:pingo
 * @Date: 2020/10/2 16:11
 * 
 */

namespace app\common\middleware;


use Closure;
use think\Config;

class AllowCrossDomain
{

    protected $cookieDomain;

    protected $header = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With,token',
    ];

    public function __construct(Config $config)
    {
        $this->cookieDomain = $config->get('cookie.domain', '');
    }

    public function handle($request, Closure $next, ?array $header = [])
    {
        $header = !empty($header) ? array_merge($this->header, $header) : $this->header;

        if (!isset($header['Access-Control-Allow-Origin'])) {
            $origin = $request->header('origin');

            if ($origin && ('' == $this->cookieDomain || strpos($origin, $this->cookieDomain))) {
                $header['Access-Control-Allow-Origin'] = $origin;
            } else {
                $header['Access-Control-Allow-Origin'] = '*';
            }
        }

        return $next($request)->header($header);
    }
}
