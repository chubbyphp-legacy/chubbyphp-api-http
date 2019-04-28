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
        $apiProblem = new Unauthorized('Token', []);

        self::assertSame(401, $apiProblem->getStatus());
        self::assertSame(['WWW-Authenticate' => ''], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.2', $apiProblem->getType());
        self::assertSame('Unauthorized', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame('Token', $apiProblem->getAuthorization());
        self::assertSame([], $apiProblem->getAuthorizationTypes());
    }

    public function testMaximal()
    {
        $apiProblem = new Unauthorized('Token', ['Basic', 'Bearer'], 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(401, $apiProblem->getStatus());
        self::assertSame(['WWW-Authenticate' => 'Basic,Bearer'], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.2', $apiProblem->getType());
        self::assertSame('Unauthorized', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame('Token', $apiProblem->getAuthorization());
        self::assertSame(['Basic', 'Bearer'], $apiProblem->getAuthorizationTypes());
    }
}
