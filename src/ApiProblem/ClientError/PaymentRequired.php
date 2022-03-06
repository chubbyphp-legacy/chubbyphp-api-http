<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class PaymentRequired extends AbstractApiProblem
{
    /**
     * @param array<int, string> $paymentTypes
     */
    public function __construct(private array $paymentTypes, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.3',
            402,
            'Payment Required',
            $detail,
            $instance
        );
    }

    /**
     * @return array<int, string>
     */
    public function getPaymentTypes(): array
    {
        return $this->paymentTypes;
    }
}
