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
        $apiProblem = new RequestEntityTooLarge('title');

        self::assertSame(413, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.14', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertNull($apiProblem->getMaxContentLength());
    }

    public function testMaximal()
    {
        $apiProblem = (new RequestEntityTooLarge('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withMaxContentLength(1024);

        self::assertSame(413, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.14', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxContentLength());
    }
}
