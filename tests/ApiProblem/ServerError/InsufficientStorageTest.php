<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InsufficientStorage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\InsufficientStorage
 */
final class InsufficientStorageTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new InsufficientStorage('title');

        self::assertSame(507, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.5', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal()
    {
        $apiProblem = (new InsufficientStorage('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance');

        self::assertSame(507, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.5', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
    }
}
