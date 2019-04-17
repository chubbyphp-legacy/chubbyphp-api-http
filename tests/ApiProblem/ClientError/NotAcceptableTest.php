<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable
 */
final class NotAcceptableTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new NotAcceptable([], 'title');

        self::assertSame(406, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.7', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getAcceptableMediaTypes());
    }

    public function testMaximal()
    {
        $apiProblem = new NotAcceptable(['application/json', 'application/xml'], 'title', 'detail', 'instance');

        self::assertSame(406, $apiProblem->getStatus());
        self::assertSame(['X-Acceptable' => 'application/json,application/xml'], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.7', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['application/json', 'application/xml'], $apiProblem->getAcceptableMediaTypes());
    }
}
