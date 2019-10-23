<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotFound;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\NotFound
 *
 * @internal
 */
final class NotFoundTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new NotFound();

        self::assertSame(404, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.5', $apiProblem->getType());
        self::assertSame('Not Found', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new NotFound('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(404, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.5', $apiProblem->getType());
        self::assertSame('Not Found', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
