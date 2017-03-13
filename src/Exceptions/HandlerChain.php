<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/3/10
 * Time: 下午6:17
 */

namespace Aixue\Common\Exceptions;


use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LoggerInterface;

class HandlerChain extends ExceptionHandler
{
    /** @var ExceptionHandler[] */
    protected $report_chain;
    protected $renderer;

    public function __construct(LoggerInterface $log)
    {
        parent::__construct($log);
        $this->report_chain = config('exception_handlers.report');
        $this->renderer = config('exception_handlers.render') ?: array_last($this->report_chain);
    }


    public function report(Exception $e)
    {
        foreach ($this->report_chain as $handler)
        {
            $handler->report($e);
        }
    }

    public function render($request, Exception $e)
    {
        return $this->renderer->render($e);
    }

}