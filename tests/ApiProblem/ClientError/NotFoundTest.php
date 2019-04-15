<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotFound;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\NotFound
 */
final class NotFoundTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new NotFound('title');

        self::assertSame(404, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.5', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = (new NotFound('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance');

        self::assertSame(404, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.5', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
