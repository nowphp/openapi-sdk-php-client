<?php

namespace AlibabaCloud\Client\Tests\Unit\Result;

use AlibabaCloud\Client\Request\RpcRequest;
use AlibabaCloud\Client\Result\Result;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class FormatTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Result
 */
class FormatTraitTest extends TestCase
{
    public function testXmlBad()
    {
        // Setup
        $request = (new RpcRequest())->format('XML');
        $result  = new Result(new Response(200, [], 'badFormat'), $request);

        // Assert
        self::assertEquals([], $result->toArray());
    }

    public function testArrayAccess()
    {
        // Setup
        $result        = new Result(new Response());
        $result['key'] = 'value';

        // Assert
        self::assertEquals('value', $result['key']);

        // Setup
        unset($result['key']);

        // Assert
        self::assertEquals(false, isset($result['key']));
    }

    public function testIteratorAggregate()
    {
        // Setup
        $result = new Result(new Response());

        // Assert
        self::assertInstanceOf(\ArrayIterator::class, $result->getIterator());
    }

    public function testToJson()
    {
        // Setup
        $result        = new Result(new Response());
        $time          = \time();
        $result[$time] = $time;

        // Assert
        self::assertEquals('{"' . $time . '":' . $time . '}', $result->toJson());
    }
}