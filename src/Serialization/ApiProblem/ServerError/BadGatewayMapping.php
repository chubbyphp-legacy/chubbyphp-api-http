<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\BadGateway;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class BadGatewayMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return BadGateway::class;
    }
}
