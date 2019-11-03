<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\ProxyAuthenticationRequired;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class ProxyAuthenticationRequiredMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return ProxyAuthenticationRequired::class;
    }
}
