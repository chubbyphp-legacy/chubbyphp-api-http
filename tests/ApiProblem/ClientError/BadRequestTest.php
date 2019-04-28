<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\BadRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\BadRequest
 */
final class BadRequestTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new BadRequest([]);

        self::assertSame(400, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.1', $apiProblem->getType());
        self::assertSame('Bad Request', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getInvalidParameters());
    }

    public function testMaximal(): void
    {
        $apiProblem = new BadRequest([
            [
                'name' => 'age',
                'reason' => 'must be a positive integer',
            ],
            [
                'name' => 'color',
                'reason' => 'must be \'green\', \'red\' or \'blue\'',
            ],
        ], 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(400, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.1', $apiProblem->getType());
        self::assertSame('Bad Request', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
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
