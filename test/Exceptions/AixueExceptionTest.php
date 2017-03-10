<?php
/**
 * Created by PhpStorm.
 * User: xintong.dai
 * Date: 17/2/21
 * Time: 上午11:02
 */

namespace Aixue\Common\Exceptions;


class AixueExceptionTest extends \PHPUnit_Framework_TestCase
{

    function testCodeAndMessage()
    {
        $previous = new \Exception();
        $e = new AixueException(99, 'test exception', $previous);
        $this->assertEquals(99, $e->getCode());
        $this->assertEquals('test exception', $e->getMessage());
        $this->assertEquals($previous, $e->getPrevious());
    }

    function testOnlyCode()
    {
        $e = new AixueException(99999);
        $this->assertEquals(99999, $e->getCode());
        var_export($e->getMessage());
        $this->assertEmpty($e->getMessage());
        $this->assertNull($e->getPrevious());
    }

}
