<?php

namespace Chubbyphp\Tests\ApiHttp\Error;

use Chubbyphp\ApiHttp\ApiProblem\PaymentRequiredApiProblem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\PaymentRequiredApiProblem
 */
final class PaymentRequiredApiProblemTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new PaymentRequiredApiProblem('title');

        self::assertSame(402, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.3', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getPaymentTypes());
    }

    public function testMaximal()
    {
        $apiProblem = (new PaymentRequiredApiProblem('title'))
            ->withTitle('other title')
            ->withDetail('detail')
            ->withInstance('instance')
            ->withPaymentTypes(['creditcard', 'maestro', 'twint']);

        self::assertSame(402, $apiProblem->getStatus());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.3', $apiProblem->getType());
        self::assertSame('other title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['creditcard', 'maestro', 'twint'], $apiProblem->getPaymentTypes());
    }
}
