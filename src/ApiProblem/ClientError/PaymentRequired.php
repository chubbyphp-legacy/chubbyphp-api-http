<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class PaymentRequired extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $paymentTypes = [];

    /**
     * @param string[]    $paymentTypes
     * @param string      $title
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $paymentTypes, string $title, string $detail = null, string $instance = null)
    {
        parent::__construct($title, $detail, $instance);

        $this->paymentTypes = $paymentTypes;
    }

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
     * @return string[]
     */
    public function getPaymentTypes(): array
    {
        return $this->paymentTypes;
    }
}
