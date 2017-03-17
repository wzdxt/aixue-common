<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/2/16
 * Time: 下午6:00
 */

namespace Aixue\Common\Exceptions;


use Exception;

class ServiceException extends Exception
{
    public function __construct($code = CODE_B_SERVICE_NOT_REACHED, $msg = null, Exception $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}
