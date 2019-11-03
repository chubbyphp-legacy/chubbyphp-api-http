<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\AbstractApiProblem;

final class Locked extends AbstractApiProblem
{
    public function __construct(string $detail = null, string $instance = null)
    {
        parent::__construct(
            'https://tools.ietf.org/html/rfc4918#section-11.3',
            423,
            'Locked',
            $detail,
            $instance
        );
    }
}
