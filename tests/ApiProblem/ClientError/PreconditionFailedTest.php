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
        $apiProblem = new PreconditionFailed('title');

        self::assertSame(412, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.13', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getMissingPreconditions());
    }

    public function testMaximal()
    {
        $apiProblem = (new PreconditionFailed('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withMissingPreconditions(['Header X-Sample is missing']);

        self::assertSame(412, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.13', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['Header X-Sample is missing'], $apiProblem->getMissingPreconditions());
    }
}
