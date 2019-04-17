<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class BadGateway extends AbstractApiProblem
{
    /**
     * @return int
     */
    public function getStatus(): int
    {
        return 502;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'https://tools.ietf.org/html/rfc2616#section-10.5.3';
    }
}
