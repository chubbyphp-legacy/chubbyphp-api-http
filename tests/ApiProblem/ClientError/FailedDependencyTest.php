<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\FailedDependency;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\FailedDependency
 */
final class FailedDependencyTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new FailedDependency('title');

        self::assertSame(424, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.4', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = (new FailedDependency('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance');

        self::assertSame(424, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.4', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
