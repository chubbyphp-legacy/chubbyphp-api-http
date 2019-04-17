<?php

namespace Chubbyphp\Tests\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\PaymentRequired;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\PaymentRequired
 */
final class PaymentRequiredTest extends TestCase
{
    public function testMinimal()
    {
        $apiProblem = new PaymentRequired([], 'title');

        self::assertSame(402, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.3', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getPaymentTypes());
    }

    public function testMaximal()
    {
        $apiProblem = new PaymentRequired(['creditcard', 'paypal'], 'title', 'detail', 'instance');

        self::assertSame(402, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.3', $apiProblem->getType());
        self::assertSame('title', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('instance', $apiProblem->getInstance());
        self::assertSame(['creditcard', 'paypal'], $apiProblem->getPaymentTypes());
    }
}
