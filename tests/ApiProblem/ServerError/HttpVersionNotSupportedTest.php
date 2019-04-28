<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\HttpVersionNotSupported;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\HttpVersionNotSupported
 */
final class HttpVersionNotSupportedTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new HttpVersionNotSupported();

        self::assertSame(505, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.6', $apiProblem->getType());
        self::assertSame('Http Version Not Supported', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new HttpVersionNotSupported('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(505, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.6', $apiProblem->getType());
        self::assertSame('Http Version Not Supported', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
