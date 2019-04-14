<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

final class PaymentRequiredApiProblem extends ApiProblem
{
    /**
     * @var string[]
     */
    private $paymentTypes = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 402;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.3';
    }

    /**
     * @param array $paymentTypes
     *
     * @return ApiProblemInterface
     */
    public function withPaymentTypes(array $paymentTypes): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->paymentTypes = $paymentTypes;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getPaymentTypes(): array
    {
        return $this->paymentTypes;
    }
}
