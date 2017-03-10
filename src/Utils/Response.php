<?php
/**
 * 响应客户端数据课时
 * User: kang
 * Date: 16/6/4
 * Time: 13:41
 */
namespace Aixue\Common\Utils;

use Request;

class Response
{
    private $method = 'web';

    public function __construct()
    {
        $source = Request::header("source", "web");
        if (!method_exists($this, $source))
        {
            $this->method = 'web';
        } else
        {
            $this->method = $source;
        }
    }

    /**
     * 成功响应,根据 header 里 source 参数,响应不同格式的数据
     *
     * @param array $data
     * @return array
     */
    public function success(array $data = array(), $msg = null)
    {
        $method = $this->method;
        return $this->$method(CODE_SUCCESS, $data, $msg);
    }

    /**
     * 错误响应
     *
     * @param int $code
     * @param string $msg
     * @return array
     */
    public function error($code = CODE_FAIL, array $data = [], $msg = null)
    {
        $method = $this->method;
        return $this->$method($code, $data, $msg);
    }

    /**
     * 响应 web 端格式
     *
     * @param array $data
     * @return array
     */
    private function web($code, array $data, $msg = null)
    {
        $response = $this->getFormatRes($code, $msg);
        if (!empty($data))
        {
            $response['data'] = $data;
        }
        return $response;
    }

    /**
     * 响应 app 端格式
     *
     * @param array $data
     * @return array
     */
    private function app($code, array $data, $msg = null)
    {
        $response = $this->getFormatRes($code, $msg);
        if (!empty($data) && !key_exists(0, $data))
        {
            $response = array_merge($response, $data);
        } else
        {
            $response['data'] = $data;
        }
        return $response;
    }


    /**
     * 响应格式
     *
     * @param $code
     * @return array
     */
    private function getFormatRes($code, $msg = null)
    {
        is_null($msg) && $msg = config("code_msg." . $code);
        $response = array(
            "status" => $code,
            "msg" => is_null($msg) ? "错误信息没写啊" : $msg,
            'uri' => $_SERVER['REQUEST_URI']
        );
        return $response;
    }

}