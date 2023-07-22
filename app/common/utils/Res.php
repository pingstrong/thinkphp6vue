<?php


namespace app\common\utils;


use app\common\utils\ErrorCode;
use app\common\utils\Message;

class Res
{

    /**
     * 成功的数据
     */
    public static function ok($data = [], $msg = Message::SUCCESS)
    {
        $result = [
            'code' => ErrorCode::SUCCESS,
            'msg' => $msg,
            'data' => $data
        ];
        return self::jsonResult($result);
    }



    /**
     * @param $msg 返回的错误信息
     * @return \think\response\Json
     */
    public static function error($msg)
    {
        $result = [
            'code' => ErrorCode::ERROR,
            'msg' => $msg
        ];
        return  self::jsonResult($result);
    }


    /**
     * @param $msg 错误信息
     * @return array 这里返回数组
     */
    public static function tokenError($msg)
    {
        $result = [
            'code' => ErrorCode::TOKENERROR,
            'msg' => $msg
        ];
        return $result;
    }


    public static function jsonResult($array)
    {
        return json($array);
    }


    public static function modelmsg($data)
    {
        $result = [
            'code' => ErrorCode::SUCCESS,
            'msg' => Message::SUCCESS,
            'data' => $data
        ];
        return $result;
    }
}
