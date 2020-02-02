<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class ExpectationFailed extends AbstractApiProblem
{
    /**
     * @var array<int, string>
     */
    private $failedExpectations = [];

    /**
     * @param array<int, string> $failedExpectations
     */
    public function __construct(array $failedExpectations, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.18',
            417,
            'Expectation Failed',
            $detail,
            $instance
        );

        $this->failedExpectations = $failedExpectations;
    }

    /**
     * @return array<int, string>
     */
    public function getFailedExpectations(): array
    {
        return $this->failedExpectations;
    }
}
