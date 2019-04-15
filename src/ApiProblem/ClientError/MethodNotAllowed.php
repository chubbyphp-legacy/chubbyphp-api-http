<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class MethodNotAllowed extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $allowedMethods = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 405;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.6';
    }

    /**
     * @param string[] $allowedMethods
     *
     * @return ApiProblemInterface
     */
    public function withAllowedMethods(array $allowedMethods): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->allowedMethods = $allowedMethods;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }
}
