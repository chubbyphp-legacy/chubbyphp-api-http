<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\FailedDependency;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\FailedDependency
 *
 * @internal
 */
final class FailedDependencyTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new FailedDependency();

        self::assertSame(424, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.4', $apiProblem->getType());
        self::assertSame('Failed Dependency', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new FailedDependency('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(424, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.4', $apiProblem->getType());
        self::assertSame('Failed Dependency', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
