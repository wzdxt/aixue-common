<?php

namespace Aixue\Common\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Illuminate\Support\Facades\Redis;
use Mail;

class EmailJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $exception;
    private $fail_num = 1;
    private $title;
    private $to;
    private $limit = true;

    public function __construct(array $exception, array $to, $limit = true)
    {
        $env = config('app.env');

        $this->title = $env . '环境AI老师端通知';
        $this->to = $to;
        $this->limit = $limit;

        $this->exception = $exception;
        $this->exception['env'] = $env;
        $this->exception['sever_addr'] = $_SERVER['SERVER_ADDR'];
    }


    public function handle()
    {
        //验证下发送限制
        if ($this->limit && $this->limitSend())
        {
            return true;
        }

        $this->send();
    }

    //限制发送条件
    private function limitSend()
    {
        //本地环境不发送
        if ($this->exception['env'] == "local")
        {
            return true;
        }
        //没有指定错误位置不发送
        if (!isset($this->exception['file']) || !isset($this->exception['line']))
        {
            return true;
        }

        $exception_id = md5($this->exception['file'] . $this->exception['line']);
        $this->exception['exception_id'] = $exception_id;

        $redis_key = REDIS_EXCEPTION_ID . ':' . $exception_id;
        $fail_num = Redis::get($redis_key);
        //超过了发送次数限制不发送
        if (!is_null($fail_num) && $fail_num >= $this->fail_num)
        {
            return true;
        }

        Redis::INCR($redis_key);
        Redis::EXPIRE($redis_key, 3600);
        return false;
    }


    private function send()
    {
        try
        {
            return Mail::send('emails.exception', ['data' => $this->exception],
                function($message)
                {
                    foreach ($this->to as $to)
                    {
                        $message->to($to);
                    }
                    $message->subject($this->title);
                }
            );
        } catch (\Exception $e)
        {
            Log::error("发送邮件都有错误啊.妈的,不发了~");
            Log::error($e->getMessage());
            return false;
        }
    }

    public function failed()
    {
        $this->exception['queue_failed'] = "卧槽,发送邮件的队列里面有错误了,快查看日志吧";
        $this->send();
    }
}
