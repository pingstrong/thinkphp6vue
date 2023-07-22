<?php


namespace app\common\service;


use app\common\utils\ErrorCode;
use app\common\utils\Message;
use app\common\utils\Res;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

class JwtService
{

    public static function createToken($data)
    {
        $key = "keyi#%^!@#";
        $token = [
            "iss" => $key,
            "aud" => '',
            "iat" => time(),
            "nbf" => time() + 3,
            "exp" => time() + 86400, //设置过期时间为1天
            "data" => $data
        ];
        $jwt = JWT::encode($token, $key, "HS256");
        return $jwt;
    }


    public static function createApiToken($data)
    {
        $key = "keyi#%^!@#";
        $token = [
            "iss" => $key,
            "aud" => '',
            "iat" => time(),
            "nbf" => time() + 3,
            "exp" => time() + 1296000, //设置过期时间为15天
            "data" => $data
        ];
        $jwt = JWT::encode($token, $key, "HS256");
        return $jwt;
    }

    public static function checkToken($token)
    {
        $key = "keyi#%^!@#";

        try {
            JWT::$leeway = 60; //当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $arr['code'] = ErrorCode::SUCCESS;
            return $arr;
        } catch (SignatureInvalidException $e) {
            return  Res::tokenError(Message::TOKENERROR);
        } catch (BeforeValidException $beforeValidException) {
            return Res::tokenError(Message::TOKENDEFALU);
        } catch (ExpiredException $expiredException) {
            return Res::tokenError(Message::TOKENNOWTIME);
        } catch (\Exception $exception) {
            return Res::tokenError(Message::TOKENNULL);
        }
    }
}
