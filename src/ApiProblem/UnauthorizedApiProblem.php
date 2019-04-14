<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem;

final class UnauthorizedApiProblem extends ApiProblem
{
    /**
     * @var string[]
     */
    private $authorizationTypes = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 401;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.2';
    }

    /**
     * @param array $authorizationTypes
     *
     * @return ApiProblemInterface
     */
    public function withAuthorizationTypes(array $authorizationTypes): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->authorizationTypes = $authorizationTypes;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getAuthorizationTypes(): array
    {
        return $this->authorizationTypes;
    }
}
