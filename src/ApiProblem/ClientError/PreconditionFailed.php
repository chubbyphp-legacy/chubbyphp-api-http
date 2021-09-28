<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class PreconditionFailed extends AbstractApiProblem
{
    /**
     * @var array<int, string>
     */
    private array $failedPreconditions = [];

    /**
     * @param array<int, string> $failedPreconditions
     */
    public function __construct(array $failedPreconditions, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.13',
            412,
            'Precondition Failed',
            $detail,
            $instance
        );

        $this->failedPreconditions = $failedPreconditions;
    }

    /**
     * @return array<int, string>
     */
    public function getFailedPreconditions(): array
    {
        return $this->failedPreconditions;
    }
}
