<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/10
 * Time: 下午2:35
 */

namespace Aixue\Common\ServiceProviders;


use Aixue\Common\Exceptions\HandlerChain;
use Illuminate\Support\ServiceProvider;

class ExceptionHandlerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
                             __DIR__.'/../../config/exception_handlers.php'  => config_path('exception_handlers.php'),
                         ],'config');
    }


    public function register()
    {
        // 公共部分的错误代码加入配置
        $this->mergeConfigFrom(__DIR__.'/../../config/code_msg.php', 'code_msg');

        $this->app->singleton(\Illuminate\Contracts\Debug\ExceptionHandler::class, function($app)
        {
            return $app->make(HandlerChain::class);
        });
    }
}