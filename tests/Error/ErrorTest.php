<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\Error\Error;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\Error\Error
 */
final class ErrorTest extends TestCase
{
    public function testScopeAndKey()
    {
        $error = new Error(
            Error::SCOPE_BODY,
            'body_not_deserializable'
        );

        self::assertSame(Error::SCOPE_BODY, $error->getScope());
        self::assertSame('body_not_deserializable', $error->getKey());
    }

    public function testScopeAndKeyAndDetail()
    {
        $error = new Error(
            Error::SCOPE_BODY,
            'body_not_deserializable',
            'the body is not deserializable'
        );

        self::assertSame(Error::SCOPE_BODY, $error->getScope());
        self::assertSame('body_not_deserializable', $error->getKey());
        self::assertSame('the body is not deserializable', $error->getDetail());
    }

    public function testScopeAndKeyAndDetailAndReference()
    {
        $error = new Error(
            Error::SCOPE_BODY,
            'body_not_deserializable',
            'the body is not deserializable',
            'model'
        );

        self::assertSame(Error::SCOPE_BODY, $error->getScope());
        self::assertSame('body_not_deserializable', $error->getKey());
        self::assertSame('the body is not deserializable', $error->getDetail());
        self::assertSame('model', $error->getReference());
    }

    public function testScopeAndKeyAndDetailAndReferenceAndArguments()
    {
        $error = new Error(
            Error::SCOPE_BODY,
            'body_not_deserializable',
            'the body is not deserializable',
            'model',
            ['contentType' => 'application/json', 'body' => '{{""}']
        );

        self::assertSame(Error::SCOPE_BODY, $error->getScope());
        self::assertSame('body_not_deserializable', $error->getKey());
        self::assertSame('the body is not deserializable', $error->getDetail());
        self::assertSame('model', $error->getReference());
        self::assertEquals(['contentType' => 'application/json', 'body' => '{{""}'], $error->getArguments());
    }
}
