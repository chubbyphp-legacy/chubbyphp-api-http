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
        $apiProblem = new ExpectationFailed([], 'title');

        self::assertSame(417, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.18', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getFailedExpectations());
    }

    public function testMaximal()
    {
        $apiProblem = new ExpectationFailed(['Expectation Failed'], 'title', 'detail', 'instance');

        self::assertSame(417, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.18', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['Expectation Failed'], $apiProblem->getFailedExpectations());
    }
}
