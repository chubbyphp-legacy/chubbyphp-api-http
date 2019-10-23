<?php

declare(strict_types=1);

namespace Chubbyphp\Tests\ApiHttp\Unit\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\PaymentRequired;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chubbyphp\ApiHttp\ApiProblem\ClientError\PaymentRequired
 *
 * @internal
 */
final class PaymentRequiredTest extends TestCase
{
    public function testMinimal(): void
    {
        $apiProblem = new PaymentRequired([]);

        self::assertSame(402, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.3', $apiProblem->getType());
        self::assertSame('Payment Required', $apiProblem->getTitle());
        self::assertNull($apiProblem->getDetail());
        self::assertNull($apiProblem->getInstance());
        self::assertSame([], $apiProblem->getPaymentTypes());
    }

    public function testMaximal(): void
    {
        $apiProblem = new PaymentRequired(['creditcard', 'paypal'], 'detail', '/cccdfd0f-0da3-4070-8e55-61bd832b47c0');

        self::assertSame(402, $apiProblem->getStatus());
        self::assertSame([], $apiProblem->getHeaders());
        self::assertSame('https://tools.ietf.org/html/rfc2616#section-10.4.3', $apiProblem->getType());
        self::assertSame('Payment Required', $apiProblem->getTitle());
        self::assertSame('detail', $apiProblem->getDetail());
        self::assertSame('/cccdfd0f-0da3-4070-8e55-61bd832b47c0', $apiProblem->getInstance());
        self::assertSame(['creditcard', 'paypal'], $apiProblem->getPaymentTypes());
    }
}
