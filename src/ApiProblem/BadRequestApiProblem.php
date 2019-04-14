<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

final class BadRequestApiProblem extends ApiProblem
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
        return 400;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.1';
    }

    /**
     * @param array $invalidParameters
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
