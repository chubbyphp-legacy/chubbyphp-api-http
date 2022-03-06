<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class RequestUriTooLong extends AbstractApiProblem
{
    public function __construct(private int $maxUriLength, ?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.4.15',
            414,
            'Request Uri Too Long',
            $detail,
            $instance
        );
    }

    public function getMaxUriLength(): int
    {
        return $this->maxUriLength;
    }
}
