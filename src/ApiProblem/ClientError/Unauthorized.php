<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class Unauthorized extends AbstractApiProblem
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
     * @return array
     */
    public function getHeaders(): array
    {
        if ([] === $this->authorizationTypes) {
            return [];
        }

        return ['WWW-Authenticate' => implode(',', $this->authorizationTypes)];
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
