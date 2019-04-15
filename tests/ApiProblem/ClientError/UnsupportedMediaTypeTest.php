<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType
 */
final class UnsupportedMediaTypeTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new UnsupportedMediaType('title');

        self::assertSame(415, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.16', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getSupportedMediaTypes());
    }

    public function testMaximal()
    {
        $apiProblem = (new UnsupportedMediaType('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withSupportedMediaTypes(['application/json', 'application/xml']);

        self::assertSame(415, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.16', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['application/json', 'application/xml'], $apiProblem->getSupportedMediaTypes());
    }
}
