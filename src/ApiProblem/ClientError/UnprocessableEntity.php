<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class UnprocessableEntity extends AbstractApiProblem
{
    /**
     * @var array[]
     */
    private $invalidParameters = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 422;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc4918#section-11.2';
    }

    /**
     * @param string[] $invalidParameters
     *
     * @return ApiProblemInterface
     */
    public function withInvalidParameters(array $invalidParameters): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->invalidParameters = $invalidParameters;

        return $clone;
    }

    /**
     * @return array
     */
    public function getInvalidParameters(): array
    {
        return $this->invalidParameters;
    }
}
