<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\HttpVersionNotSupported;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class HttpVersionNotSupportedMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return HttpVersionNotSupported::class;
    }
}
