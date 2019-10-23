<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\PreconditionFailed;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\PreconditionFailed
 *
 * @internal
 */
final class PreconditionFailedTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new PreconditionFailed([]);

        self::assertSame(412, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.13', $apiProblem->getType());
        self::assertSame('Precondition Failed', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getFailedPreconditions());
    }

    public function testMaximal(): void
    {
        $apiProblem = new PreconditionFailed(['Failed Precondition'], 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(412, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.13', $apiProblem->getType());
        self::assertSame('Precondition Failed', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame(['Failed Precondition'], $apiProblem->getFailedPreconditions());
    }
}
