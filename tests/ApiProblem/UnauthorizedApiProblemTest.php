<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\ApiProblem\UnauthorizedApiProblem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\UnauthorizedApiProblem
 */
final class UnauthorizedApiProblemTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new UnauthorizedApiProblem('title');

        self::assertSame(401, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.2', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getAuthorizationTypes());
    }

    public function testMaximal()
    {
        $apiProblem = (new UnauthorizedApiProblem('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withAuthorizationTypes(['oauth2', 'jwt']);

        self::assertSame(401, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.2', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['oauth2', 'jwt'], $apiProblem->getAuthorizationTypes());
    }
}
