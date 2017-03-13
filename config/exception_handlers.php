<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/10
 * Time: 下午6:30
 */

return [
    // 配置异常处理串
    // 按顺序调用report
    // 未设定render时,使用最后一个report作为render
    'report' => [
        App\Exceptions\Handler::class,
    ],
    'render' => Aixue\Common\Exceptions\Handler::class,
];