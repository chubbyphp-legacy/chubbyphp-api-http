<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Forbidden;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class ForbiddenMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return Forbidden::class;
    }
}
