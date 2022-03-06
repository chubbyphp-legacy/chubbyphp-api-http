<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class RequestEntityTooLarge extends AbstractApiProblem
{
    public function __construct(private int $maxContentLength, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.14',
            413,
            'Request Entity Too Large',
            $detail,
            $instance
        );
    }

    public function getMaxContentLength(): int
    {
        return $this->maxContentLength;
    }
}
