<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError
 *
 * @internal
 */
final class InternalServerErrorTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new InternalServerError();

        self::assertSame(500, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.1', $apiProblem->getType());
        self::assertSame('Internal Server Error', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertNull($apiProblem->getBacktrace());
    }

    public function testMaximal(): void
    {
        $backtrace = [
            [
                'class' => 'RuntimeException',
                'message' => 'runtime exception',
                'code' => 5000,
            ],
        ];

        $apiProblem = new InternalServerError('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');
        $apiProblem->setBacktrace($backtrace);

        self::assertSame(500, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.5.1', $apiProblem->getType());
        self::assertSame('Internal Server Error', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame($backtrace, $apiProblem->getBacktrace());
    }
}
