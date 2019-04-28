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
        $apiProblem = new ExpectationFailed([]);

        self::assertSame(417, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.18', $apiProblem->getType());
        self::assertSame('Expectation Failed', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getFailedExpectations());
    }

    public function testMaximal()
    {
        $apiProblem = new ExpectationFailed(['Expectation Failed'], 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(417, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.18', $apiProblem->getType());
        self::assertSame('Expectation Failed', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame(['Expectation Failed'], $apiProblem->getFailedExpectations());
    }
}
