<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;
use Chubbyphp\ApiHttp\ApiProblem\ApiProblemInterface;

final class RequestEntityTooLarge extends AbstractApiProblem
{
    /**
     * @var int|null
     */
    private $maxContentLength;

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 413;
    }

    /**
     * @return int
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.14';
    }

    /**
     * @param int|null $maxContentLength
     *
     * @return ApiProblemInterface
     */
    public function withMaxContentLength(int $maxContentLength = null): ApiProblemInterface
    {
        $clone = clone $this;
        $clone->maxContentLength = $maxContentLength;

        return $clone;
    }

    /**
     * @return int|null
     */
    public function getMaxContentLength()
    {
        return $this->maxContentLength;
    }
}
