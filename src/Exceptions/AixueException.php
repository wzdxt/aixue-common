<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/2/16
 * Time: 下午6:00
 */

namespace Aixue\Common\Exceptions;


use Exception;

class AixueException extends Exception
{
    const CODE_MSG = [
        //CODE_B_VALID_FAIL => '验证错误',
    ];
    const UNDEFINED_ERROR_MSG = '未知错误';

    public function __construct($code, $msg = '', Exception $previous = null)
    {
        $msg = $msg ?: (@static::CODE_MSG[$code] ?: static::UNDEFINED_ERROR_MSG);
        parent::__construct($msg, $code, $previous);
    }
}
