<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError
 */
final class InternalServerErrorTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new InternalServerError('title');

        self::assertSame(500, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.1', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = new InternalServerError('title', 'detail', 'instance');

        self::assertSame(500, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.1', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
