<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Locked;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\Locked
 */
final class LockedTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new Locked('title');

        self::assertSame(423, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.3', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = (new Locked('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance');

        self::assertSame(423, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.3', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
