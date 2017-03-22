<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/22
 * Time: 上午11:04
 */

namespace Aixue\Common\Middleware;


use Closure;

class RequestIdMiddleware
{
    public function handle($request, Closure $next)
    {
        if (empty($_SERVER['HTTP_X_REQUEST_UUID']))
        {
            $_SERVER['HTTP_X_REQUEST_UUID'] = uniqid();
        }
        app('config')->set('request.request_id', $_SERVER['HTTP_X_REQUEST_UUID']);
    }

}