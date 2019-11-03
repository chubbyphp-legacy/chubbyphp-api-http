<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ServerError;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class InternalServerErrorMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return InternalServerError::class;
    }
}
