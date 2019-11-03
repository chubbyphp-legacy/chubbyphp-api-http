<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class InsufficientStorage extends AbstractApiProblem
{
    public function __construct(string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc4918#section-11.5',
            507,
            'Insufficient Storage',
            $detail,
            $instance
        );
    }
}
