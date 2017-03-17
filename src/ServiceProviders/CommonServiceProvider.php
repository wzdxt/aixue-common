<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/17
 * Time: 下午3:35
 */

namespace Aixue\Common\ServiceProviders;


use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class CommonServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        if (config('app.debug'))
        {
            \DB::listen(function($event)
            {
                \Log::debug('SQL: ' . $event->sql, [
                    'bindings' => $event->bindings,
                    'connection' => $event->connectionName,
                    'time' => $event->time,
                ]);
            });
        }
    }

    public function register()
    {

    }

}