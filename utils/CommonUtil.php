<?php


namespace Utils;


use Exceptions\ApiException;

class CommonUtil
{
    public static function throwApiException($code, $msg, $data = [])
    {
        throw new ApiException($msg, (int)$code, $data);
    }
}