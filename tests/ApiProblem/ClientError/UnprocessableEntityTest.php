<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnprocessableEntity;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\UnprocessableEntity
 */
final class UnprocessableEntityTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new UnprocessableEntity('title');

        self::assertSame(422, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.2', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getInvalidParameters());
    }

    public function testMaximal()
    {
        $apiProblem = (new UnprocessableEntity('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withInvalidParameters([
                [
                    'name' => 'age',
                    'reason' => 'must be a positive integer',
                ],
                [
                    'name' => 'color',
                    'reason' => 'must be \'green\', \'red\' or \'blue\'',
                ],
            ]);

        self::assertSame(422, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc4918#section-11.2', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame([
            [
                'name' => 'age',
                'reason' => 'must be a positive integer',
            ],
            [
                'name' => 'color',
                'reason' => 'must be \'green\', \'red\' or \'blue\'',
            ],
        ], $apiProblem->getInvalidParameters());
    }
}
