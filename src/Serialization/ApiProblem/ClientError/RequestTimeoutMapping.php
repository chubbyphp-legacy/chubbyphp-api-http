<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\RequestTimeout;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class RequestTimeoutMapping extends AbstractApiProblemMapping
{
    /**
     * @return string
     */
    public function getClass(): string
    {
        return RequestTimeout::class;
    }
}
