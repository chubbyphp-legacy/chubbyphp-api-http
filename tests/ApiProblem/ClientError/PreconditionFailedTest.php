<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\PreconditionFailed;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\PreconditionFailed
 */
final class PreconditionFailedTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new PreconditionFailed([], 'title');

        self::assertSame(412, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.13', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getFailedPreconditions());
    }

    public function testMaximal()
    {
        $apiProblem = new PreconditionFailed(['Failed Precondition'], 'title', 'detail', 'instance');

        self::assertSame(412, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.13', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['Failed Precondition'], $apiProblem->getFailedPreconditions());
    }
}
