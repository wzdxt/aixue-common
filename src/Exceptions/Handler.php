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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Input;
use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use DispatchesJobs;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        try{
            if(! $this->shouldntReport($e))
            {
                $data = [
                    'title'     => "未捕获的代码异常错误",
                    'error_msg' =>  $e->getMessage(),
                    'file'      =>  $e->getFile(),
                    'line'      =>  $e->getLine(),
                    'url'       =>  url()->full(),
                    'params'    =>  json_encode(Input::all())
                ];
                $to = config('mail.worker');
                $this->dispatch(new EmailJob($data, $to));
            }
        }catch (Exception $excep){
        }
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $trace = $e->getTraceAsString();
        Log::error(implode(" ",[
            $request->method(),
            $request->fullUrl(),
            'ERROR:'.$e->getCode(),
            -1,
            PHP_EOL.'ErrorMessage: '.$e->getMessage(),
            PHP_EOL.'StackTrace: ',
            PHP_EOL.$trace,
        ]).PHP_EOL,$request->all());

        $debug = config("app.debug");
        if(!$debug)
        {
            $err = (new Response())->error($e->getCode(), $e->getMessage());
            return response()->json($err);
        }
        return parent::render($request, $e);
    }
}