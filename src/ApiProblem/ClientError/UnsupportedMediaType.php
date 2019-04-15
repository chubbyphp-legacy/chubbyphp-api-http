<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class UnsupportedMediaType extends AbstractApiProblem
{
    /**
     * @var string[]
     */
    private $supportedMediaTypes = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 415;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.16';
    }

    /**
     * @param string[] $supportedMediaTypes
     *
     * @return ApiProblemInterface
     */
    public function withSupportedMediaTypes(array $supportedMediaTypes): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->supportedMediaTypes = $supportedMediaTypes;

        return $clone;
    }

    /**
     * @return string[]
     */
    public function getSupportedMediaTypes(): array
    {
        return $this->supportedMediaTypes;
    }
}
