<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\GatewayTimeout;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class GatewayTimeoutMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return GatewayTimeout::class;
    }
}
