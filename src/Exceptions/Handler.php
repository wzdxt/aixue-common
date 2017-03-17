<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/10
 * Time: 下午2:36
 */

namespace Aixue\Common\Exceptions;


use Aixue\Common\Utils\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $debug = config("app.debug");
        if (!$debug)
        {
            switch (get_class($e))
            {
                case  AixueException::class:
                case  ServiceException::class:
                    $err = (new Response())->error($e->getCode(), $e->getMessage());
                    break;
                default:
                    $err = (new Response())->error(CODE_FAIL);
                    break;
            }
            return response()->json($err);
        }
        return parent::render($request, $e);
    }
}