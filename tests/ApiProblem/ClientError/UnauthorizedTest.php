<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Unauthorized;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\Unauthorized
 */
final class UnauthorizedTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new Unauthorized([], 'title');

        self::assertSame(401, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.2', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getAuthorizationTypes());
    }

    public function testMaximal()
    {
        $apiProblem = new Unauthorized(['Basic', 'Bearer'], 'title', 'detail', 'instance');

        self::assertSame(401, $apiProblem->getStatus());
        self::assertSame(['WWW-Authenticate' => 'Basic,Bearer'], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.2', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['Basic', 'Bearer'], $apiProblem->getAuthorizationTypes());
    }
}
