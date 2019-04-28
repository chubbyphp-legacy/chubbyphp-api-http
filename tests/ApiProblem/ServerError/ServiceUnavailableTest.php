<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\ServiceUnavailable;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\ServiceUnavailable
 */
final class ServiceUnavailableTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new ServiceUnavailable();

        self::assertSame(503, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.4', $apiProblem->getType());
        self::assertSame('Service Unavailable', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = new ServiceUnavailable('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(503, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.4', $apiProblem->getType());
        self::assertSame('Service Unavailable', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
