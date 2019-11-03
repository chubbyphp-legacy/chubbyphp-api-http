<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Serialization\ApiProblem\ClientError;

use Chubbyphp\ApiHttp\ApiProblem\ClientError\Conflict;
use Chubbyphp\ApiHttp\Serialization\ApiProblem\AbstractApiProblemMapping;

final class ConflictMapping extends AbstractApiProblemMapping
{
    public function getClass(): string
    {
        return Conflict::class;
    }
}
