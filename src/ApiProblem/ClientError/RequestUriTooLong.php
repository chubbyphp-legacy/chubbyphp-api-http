<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class RequestUriTooLong extends AbstractApiProblem
{
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 414;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.4.15';
    }
}
