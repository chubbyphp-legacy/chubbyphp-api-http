<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class PreconditionFailed extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $failedPreconditions = [];

    /**
     * @param string[]    $failedPreconditions
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(array $failedPreconditions, string $detail = null, string $instance = null)
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
     * @return string[]
     */
    public function getFailedPreconditions(): array
    {
        return $this->failedPreconditions;
    }
}
