<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\ExpectationFailed;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\ExpectationFailed
 */
final class ExpectationFailedTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new ExpectationFailed('title');

        self::assertSame(417, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.18', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getMissingExpectations());
    }

    public function testMaximal()
    {
        $apiProblem = (new ExpectationFailed('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withMissingExpectations(['Header X-Sample is missing']);

        self::assertSame(417, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.18', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['Header X-Sample is missing'], $apiProblem->getMissingExpectations());
    }
}
