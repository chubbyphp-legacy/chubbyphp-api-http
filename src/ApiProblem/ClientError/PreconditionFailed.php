<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class PreconditionFailed extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $missingPreconditions = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 412;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.13';
    }

    /**
     * @param string[] $missingPreconditions
     *
     * @return ApiProblemInterface
     */
    public function withMissingPreconditions(array $missingPreconditions): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->missingPreconditions = $missingPreconditions;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getMissingPreconditions(): array
    {
        return $this->missingPreconditions;
    }
}
