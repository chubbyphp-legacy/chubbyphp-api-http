<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\ApiProblem\ApiProblem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ApiProblem
 */
final class ApiProblemTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new class('title') extends ApiProblem
        {
            public function getStatus(): int
            {
                return 418;
            }

            public function getType(): string
            {
                return 'https://im-a-teapot.com';
            }
        };

        self::assertSame(418, $apiProblem->getStatus());
        self::assertSame('https://im-a-teapot.com', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = new class('title') extends ApiProblem
        {
            public function getStatus(): int
            {
                return 418;
            }

            public function getType(): string
            {
                return 'https://im-a-teapot.com';
            }
        };

        $apiProblem = $apiProblem
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance');

        self::assertSame(418, $apiProblem->getStatus());
        self::assertSame('https://im-a-teapot.com', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}