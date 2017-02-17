<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/2/16
 * Time: 下午6:00
 */

namespace Exceptions;


use Exception;

class AixueException extends Exception
{
    const CODE_MSG = [
        CODE_RPC_MODULE_NOT_EXISTS => '模块不存在',
        CODE_RPC_METHOD_NOT_EXISTS => '方法不存在',
    ];
    const UNDEFINED_ERROR_MSG = '未知错误';

    public function __construct($code)
    {
        parent::__construct(@static::CODE_MSG[$code] ?: static::UNDEFINED_ERROR_MSG, $code);
    }
}