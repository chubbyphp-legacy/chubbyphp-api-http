<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\MethodNotAllowed;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\MethodNotAllowed
 */
final class MethodNotAllowedTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new MethodNotAllowed('PUT', []);

        self::assertSame(405, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.6', $apiProblem->getType());
        self::assertSame('Method Not Allowed', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame('PUT', $apiProblem->getMethod());
        self::assertSame([], $apiProblem->getAllowedMethods());
    }

    public function testMaximal()
    {
        $apiProblem = new MethodNotAllowed('PUT', ['GET', 'POST'], 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(405, $apiProblem->getStatus());
        self::assertSame(['Allow' => 'GET,POST'], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.6', $apiProblem->getType());
        self::assertSame('Method Not Allowed', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame('PUT', $apiProblem->getMethod());
        self::assertSame(['GET', 'POST'], $apiProblem->getAllowedMethods());
    }
}
