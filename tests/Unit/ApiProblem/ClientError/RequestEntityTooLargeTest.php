<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestEntityTooLarge;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestEntityTooLarge
 *
 * @internal
 */
final class RequestEntityTooLargeTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new RequestEntityTooLarge(1024);

        self::assertSame(413, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.14', $apiProblem->getType());
        self::assertSame('Request Entity Too Large', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxContentLength());
    }

    public function testMaximal(): void
    {
        $apiProblem = new RequestEntityTooLarge(1024, 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(413, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.14', $apiProblem->getType());
        self::assertSame('Request Entity Too Large', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame(1024, $apiProblem->getMaxContentLength());
    }
}
