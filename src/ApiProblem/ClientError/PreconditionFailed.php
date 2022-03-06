<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class PreconditionFailed extends AbstractApiProblem
{
    /**
     * @param array<int, string> $failedPreconditions
     */
    public function __construct(private array $failedPreconditions, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.13',
            412,
            'Precondition Failed',
            $detail,
            $instance
        );
    }

    /**
     * @return array<int, string>
     */
    public function getFailedPreconditions(): array
    {
        return $this->failedPreconditions;
    }
}
