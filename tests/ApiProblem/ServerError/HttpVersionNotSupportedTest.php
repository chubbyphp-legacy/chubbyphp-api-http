<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\HttpVersionNotSupported;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\HttpVersionNotSupported
 */
final class HttpVersionNotSupportedTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new HttpVersionNotSupported('title');

        self::assertSame(505, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.6', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = (new HttpVersionNotSupported('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance');

        self::assertSame(505, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.6', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
