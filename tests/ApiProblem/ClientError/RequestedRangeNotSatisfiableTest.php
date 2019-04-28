<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestedRangeNotSatisfiable;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestedRangeNotSatisfiable
 */
final class RequestedRangeNotSatisfiableTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new RequestedRangeNotSatisfiable();

        self::assertSame(416, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.17', $apiProblem->getType());
        self::assertSame('Requested Range Not Satisfiable', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new RequestedRangeNotSatisfiable('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(416, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.17', $apiProblem->getType());
        self::assertSame('Requested Range Not Satisfiable', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
