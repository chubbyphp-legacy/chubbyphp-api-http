<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class ExpectationFailed extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $missingExpectations = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 417;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.18';
    }

    /**
     * @param string[] $missingExpectations
     *
     * @return ApiProblemInterface
     */
    public function withMissingExpectations(array $missingExpectations): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->missingExpectations = $missingExpectations;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getMissingExpectations(): array
    {
        return $this->missingExpectations;
    }
}
