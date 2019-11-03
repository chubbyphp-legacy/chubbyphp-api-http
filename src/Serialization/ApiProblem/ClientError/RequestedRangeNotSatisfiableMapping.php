<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestedRangeNotSatisfiable;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class RequestedRangeNotSatisfiableMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return RequestedRangeNotSatisfiable::class;
    }
}
