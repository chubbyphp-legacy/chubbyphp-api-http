<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\ApiProblem\BadRequestApiProblem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\BadRequestApiProblem
 */
final class BadRequestApiProblemTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new BadRequestApiProblem('title');

        self::assertSame(400, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.1', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getInvalidParameters());
    }

    public function testMaximal()
    {
        $apiProblem = (new BadRequestApiProblem('title'))
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

        self::assertSame(400, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.1', $apiProblem->getType());
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
