<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\NotAcceptable
 */
final class NotAcceptableTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new NotAcceptable('application/x-yaml', []);

        self::assertSame(406, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.7', $apiProblem->getType());
        self::assertSame('Not Acceptable', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame('application/x-yaml', $apiProblem->getAccept());
        self::assertSame([], $apiProblem->getAcceptables());
    }

    public function testMaximal(): void
    {
        $apiProblem = new NotAcceptable(
            'application/x-yaml',
            ['application/json', 'application/xml'],
            'detail',
            '/cccdfd0f-0da3-4070-8e55-61bd832b47c0'
        );

        self::assertSame(406, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.7', $apiProblem->getType());
        self::assertSame('Not Acceptable', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame('application/x-yaml', $apiProblem->getAccept());
        self::assertSame(['application/json', 'application/xml'], $apiProblem->getAcceptables());
    }
}
