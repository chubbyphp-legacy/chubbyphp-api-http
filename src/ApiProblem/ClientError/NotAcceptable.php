<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class NotAcceptable extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $acceptableMediaTypes = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 406;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        if ([] === $this->acceptableMediaTypes) {
            return [];
        }

        return ['X-Acceptable' => implode(',', $this->acceptableMediaTypes)];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.7';
    }

    /**
     * @param string[] $acceptableMediaTypes
     *
     * @return ApiProblemInterface
     */
    public function withAcceptableMediaTypes(array $acceptableMediaTypes): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->acceptableMediaTypes = $acceptableMediaTypes;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getAcceptableMediaTypes(): array
    {
        return $this->acceptableMediaTypes;
    }
}
