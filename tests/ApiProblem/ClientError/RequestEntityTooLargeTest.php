<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestEntityTooLarge;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestEntityTooLarge
 */
final class RequestEntityTooLargeTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new RequestEntityTooLarge(1024, 'title');

        self::assertSame(413, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.14', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxContentLength());
    }

    public function testMaximal()
    {
        $apiProblem = new RequestEntityTooLarge(1024, 'title', 'detail', 'instance');

        self::assertSame(413, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.14', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxContentLength());
    }
}
