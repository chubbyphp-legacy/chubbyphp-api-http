<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class NotImplemented extends AbstractApiProblem
{
    public function __construct(?string $detail = null, ?string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc2616#section-10.5.2',
            501,
            'Not Implemented',
            $detail,
            $instance
        );
    }
}
