<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestUriTooLong;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestUriTooLong
 */
final class RequestUriTooLongTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new RequestUriTooLong(1024);

        self::assertSame(414, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.15', $apiProblem->getType());
        self::assertSame('Request Uri Too Long', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxUriLength());
    }

    public function testMaximal()
    {
        $apiProblem = new RequestUriTooLong(1024, 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(414, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.15', $apiProblem->getType());
        self::assertSame('Request Uri Too Long', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxUriLength());
    }
}
