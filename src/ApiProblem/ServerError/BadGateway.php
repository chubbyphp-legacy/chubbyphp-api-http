<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class BadGateway extends AbstractApiProblem
{
    /**
     * @param string|null $detail
     * @param string|null $instance
     */
    public function __construct(string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.5.3',
            502,
            'Bad Gateway',
            $detail,
            $instance
        );
    }
}
