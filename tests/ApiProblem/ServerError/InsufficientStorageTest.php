<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InsufficientStorage;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ServerError\InsufficientStorage
 */
final class InsufficientStorageTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new InsufficientStorage();

        self::assertSame(507, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.5', $apiProblem->getType());
        self::assertSame('Insufficient Storage', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
    }

    public function testMaximal(): void
    {
        $apiProblem = new InsufficientStorage('detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(507, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.5', $apiProblem->getType());
        self::assertSame('Insufficient Storage', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
    }
}
