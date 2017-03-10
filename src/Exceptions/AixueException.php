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
    public function __construct($code, $msg = null, Exception $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}
