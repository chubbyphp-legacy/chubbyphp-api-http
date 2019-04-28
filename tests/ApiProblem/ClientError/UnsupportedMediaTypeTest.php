<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\UnsupportedMediaType
 */
final class UnsupportedMediaTypeTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new UnsupportedMediaType('application/x-yaml', []);

        self::assertSame(415, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.16', $apiProblem->getType());
        self::assertSame('Unsupported Media Type', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame('application/x-yaml', $apiProblem->getMediaType());
        self::assertSame([], $apiProblem->getSupportedMediaTypes());
    }

    public function testMaximal()
    {
        $apiProblem = new UnsupportedMediaType(
            'application/x-yaml',
            ['application/json', 'application/xml'],
            'detail',
            '/cccdfd0f-0da3-4070-8e55-61bd832b47c0'
        );

        self::assertSame(415, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.16', $apiProblem->getType());
        self::assertSame('Unsupported Media Type', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame('application/x-yaml', $apiProblem->getMediaType());
        self::assertSame(['application/json', 'application/xml'], $apiProblem->getSupportedMediaTypes());
    }
}
