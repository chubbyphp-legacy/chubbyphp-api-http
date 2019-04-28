<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem
 */
final class ConflictTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new class() extends AbstractApiProblem {
            public function __construct(string $detail = null, string $instance = null)
            {
                parent::__construct('https://im-a-teapot.com', 418, 'Im a Teapot', $detail, $instance);
            }
        };

        self::assertSame(418, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://im-a-teapot.com', $apiProblem->getType());
        self::assertSame('Im a Teapot', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new class('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0') extends AbstractApiProblem {
            public function __construct(string $detail = null, string $instance = null)
            {
                parent::__construct('https://im-a-teapot.com', 418, 'Im a Teapot', $detail, $instance);
            }
        };

        self::assertSame(418, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://im-a-teapot.com', $apiProblem->getType());
        self::assertSame('Im a Teapot', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
