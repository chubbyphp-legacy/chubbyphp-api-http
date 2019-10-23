<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Conflict;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\Conflict
 *
 * @internal
 */
final class ConflictTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new Conflict();

        self::assertSame(409, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.10', $apiProblem->getType());
        self::assertSame('Conflict', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new Conflict('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(409, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.10', $apiProblem->getType());
        self::assertSame('Conflict', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
