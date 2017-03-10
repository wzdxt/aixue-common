<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/10
 * Time: 下午2:35
 */

namespace Aixue\Common\ServiceProviders;


use Aixue\Common\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;

class ExceptionHandlerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\Illuminate\Contracts\Debug\ExceptionHandler::class, function($app)
        {
            return app()->make(Handler::class);
        });
    }
}