<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem
 */
final class ConflictTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new class('title') extends AbstractApiProblem {
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
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://im-a-teapot.com', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = new class('title', 'detail', 'instance') extends AbstractApiProblem {
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
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://im-a-teapot.com', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
